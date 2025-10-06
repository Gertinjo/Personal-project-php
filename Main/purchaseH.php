<?php
include '../database/config.php';

// You might want to add authentication check here for admin

$sql = "SELECT p.id, p.quantity, p.purchase_datetime, b.Book_name, b.Price 
        FROM purchases p
        JOIN books b ON p.book_id = b.id
        ORDER BY p.purchase_datetime DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Admin - All Purchases</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        padding: 40px 20px;
        color: #2d3436;
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #0984e3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    }
    thead {
        background-color: #0984e3;
        color: white;
    }
    thead th {
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
    }
    tbody tr:hover {
        background-color: #dfe6e9;
    }
    tbody td {
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
    }
    .total {
        font-weight: 700;
        color: #10ac84;
    }
    @media (max-width: 700px) {
        body {
            padding: 20px 10px;
        }
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            display: none;
        }
        tbody tr {
            margin-bottom: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 15px;
        }
        tbody td {
            border: none;
            padding: 10px 0;
            position: relative;
            padding-left: 50%;
            text-align: right;
        }
        tbody td::before {
            position: absolute;
            top: 10px;
            left: 15px;
            width: 45%;
            white-space: nowrap;
            font-weight: 600;
            content: attr(data-label);
            color: #636e72;
            text-align: left;
        }
    }
                a.back-link {
            display: inline-block;
            margin-bottom: 25px;
            color: #2d98da;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
</style>
</head>
<body>




    <h1>All Purchases</h1>
    <?php if (count($purchases) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Book Name</th>
                <th>Quantity (Sasia)</th>
                <th>Purchase Date</th>
                <th>Purchase Time</th>
                <th>Price per Book</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchases as $purchase): 
                $date = date('Y-m-d', strtotime($purchase['purchase_datetime']));
                $time = date('H:i:s', strtotime($purchase['purchase_datetime']));
                $total = $purchase['Price'] * $purchase['quantity'];
            ?>
            <tr>
                <td data-label="Purchase ID"><?php echo $purchase['id']; ?></td>
                <td data-label="Book Name"><?php echo htmlspecialchars($purchase['Book_name']); ?></td>
                <td data-label="Quantity (Sasia)"><?php echo (int)$purchase['quantity']; ?></td>
                <td data-label="Purchase Date"><?php echo $date; ?></td>
                <td data-label="Purchase Time"><?php echo $time; ?></td>
                <td data-label="Price per Book">$<?php echo number_format($purchase['Price'], 2); ?></td>
                <td class="total" data-label="Total Amount">$<?php echo number_format($total, 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center; font-size:18px;">No purchases found.</p>
    <?php endif; ?>


    <a class="back-link" href="admin_dashboard.php">&larr; Back to dashboard</a>
</body>
</html>
