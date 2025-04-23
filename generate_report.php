<?php
session_start();
require_once('tcpdf/tcpdf.php');
require_once('db_connect.php'); // Ensure your database connection is included

// Extend TCPDF class for customization
class MYPDF extends TCPDF {
    // Custom Header
    public function Header() {
        // Set a low opacity for the background image
        $this->SetAlpha(0.2);
        // Add the full-page background image (logo.jpg)
        $this->Image('logo.jpg', 0, 0, $this->getPageWidth(), $this->getPageHeight(), 'JPG', '', '', false, 300, '', false, false, 0);
        // Reset alpha to default
        $this->SetAlpha(1);

        // Add the logo in the header (with full opacity)
        $this->Image('logo.jpg', 10, 10, 40, '', 'JPG');
        // Title: Use customer name if set, else default title
        $title = isset($_SESSION['customer_name']) ? htmlspecialchars($_SESSION['customer_name']) . " - Sales Report" : "Shoe System - Sales Report";
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(0, 15, $title, 0, 1, 'C');
        $this->Ln(10);
    }
    
    // Custom Footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 10);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create new PDF document
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 30, 10); // Top margin leaves space for header
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Fetch data from the database
$sql = "SELECT 
            orders.Order_ID, 
            customers.Name AS CustomerName, 
            shoes.name AS ProductName, 
            order_details.Quantity, 
            (order_details.Quantity * shoes.price) AS TotalPrice, 
            orders.Order_Date AS Order_Date
        FROM orders
        JOIN customers ON orders.order_ID = customers.ID
        JOIN order_details ON orders.Order_ID = order_details.Order_ID
        JOIN shoes ON order_details.shoe_id = shoes.shoe_id
        ORDER BY orders.Order_Date DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Build the HTML content for the PDF
$html = '<table border="1" cellpadding="5">
            <thead>
                <tr style="background-color: #004085; color: white;">
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price ($)</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['Order_ID'] . '</td>
                    <td>' . $row['CustomerName'] . '</td>
                    <td>' . $row['ProductName'] . '</td>
                    <td>' . $row['Quantity'] . '</td>
                    <td>' . number_format($row['TotalPrice'], 2) . '</td>
                    <td>' . date('Y-m-d', strtotime($row['Order_Date'])) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="6" align="center">No orders found</td></tr>';
}

$html .= '</tbody></table>';

// Output the HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF document to browser (D = download)
$pdf->Output('sales_report.pdf', 'D');
?>
