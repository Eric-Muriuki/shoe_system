<?php
session_start();
require_once('tcpdf/tcpdf.php');
require_once('db_connect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customerId = $_SESSION['user_id'];

// Extend TCPDF for custom header/footer
class CustomerPDF extends TCPDF {
    // Custom Header
    public function Header() {
        // Logo (adjust path if needed)
        $imageFile = 'logo.jpg';
        $this->Image($imageFile, 10, 10, 40, '', 'JPG');
        // Title
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(0, 15, 'My Orders Report', 0, 1, 'C');
        $this->Ln(5);
    }
    
    // Custom Footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create new PDF document
$pdf = new CustomerPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 30, 10); // leave space for header
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Fetch the orders for the logged in customer
$sql = "SELECT order_id, order_date, total, status FROM orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

// Build the HTML content for the PDF
$html = '<table border="1" cellpadding="5">
            <thead>
              <tr style="background-color: #004085; color: #fff;">
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total ($)</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['order_id'] . '</td>
                    <td>' . date("Y-m-d", strtotime($row['order_date'])) . '</td>
                    <td>' . number_format($row['total'], 2) . '</td>
                    <td>' . ucfirst($row['status']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="4" align="center">No orders found</td></tr>';
}

$html .= '</tbody></table>';

// Write HTML to PDF and output the file (force download)
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('my_orders_report.pdf', 'D');
?>
