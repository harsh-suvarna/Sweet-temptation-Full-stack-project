<?php
include('../components/database.php');

// Fetch messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - View Messages</title>
  <link rel="stylesheet" href="../css/admin.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 30px;
      background-color: #f9f9f9;
      color: #333;
    }
    .container{
      margin-left:250px;

    }

    h1 {
      text-align: center;
      color: #444;
      margin-bottom: 40px;
      font-size: 32px;
    }

    table {
      width: 100%;
      max-width: 1300px;
      margin: 0 auto;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      border-radius: 12px;
      overflow: hidden;
      font-size: 18px;
    }

    th, td {
      padding: 18px 22px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .delete-btn {
      background-color: #dc3545;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 20px;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .delete-btn:hover {
      background-color: #c82333;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      tr {
        margin-bottom: 20px;
      }

      td {
        position: relative;
        padding-left: 55%;
      }

      td::before {
        position: absolute;
        left: 15px;
        top: 18px;
        font-weight: bold;
        white-space: nowrap;
        font-size: 16px;
      }

      td:nth-of-type(1)::before { content: "ID"; }
      td:nth-of-type(2)::before { content: "Name"; }
      td:nth-of-type(3)::before { content: "Email"; }
      td:nth-of-type(4)::before { content: "Phone"; }
      td:nth-of-type(5)::before { content: "Message"; }
      td:nth-of-type(6)::before { content: "Received At"; }
      td:nth-of-type(7)::before { content: "Action"; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Contact Form Messages</h1>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Received At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="delete_message.php?id=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this message?')" 
                   class="delete-btn">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7">No messages found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php $conn->close(); ?>
