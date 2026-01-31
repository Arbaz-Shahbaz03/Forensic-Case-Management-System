<?php include "db.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Forensic Case Manager</title>
    <style>
        body {
            font-family: Arial;
            background-color: #0d1117;
            color: white;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #161b22;
            padding: 20px;
            text-align: center;
            font-size: 22px;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .container {
            width: 80%;
            margin: auto;
            margin-top: 30px;
        }
        .card {
            background: #1c2128;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 5px;
            color: white;
            margin-top: 10px;
        }
        button {
            padding: 10px 20px;
            background: #238636;
            border: none;
            margin-top: 15px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #30363d;
        }
        th {
            background: #21262d;
        }
        .delete-btn {
            background: #da3633;
        }
    </style>
</head>
<body>

<div class="navbar">🔍 Forensic Case Management System</div>

<div class="container">

    <!-- Add New Case Form -->
    <div class="card">
        <h2>Add New Case</h2>

        <form action="actions.php" method="POST">
            <input type="hidden" name="action" value="add">

            <label>Case Title</label>
            <input type="text" name="title" required>

            <label>Case Type</label>
            <select name="type" required>
                <option value="Cyber Crime">Cyber Crime</option>
                <option value="Homicide">Homicide</option>
                <option value="Fraud">Fraud</option>
                <option value="Robbery">Robbery</option>
                <option value="Other">Other</option>
            </select>

            <label>Description / Evidence Notes</label>
            <textarea name="description" rows="5" required></textarea>

            <button type="submit">Add Case</button>
        </form>
    </div>

    <!-- Case List -->
    <div class="card">
        <h2>All Cases</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Case Title</th>
                <th>Type</th>
                <th>Description</th>
                <th>Delete</th>
            </tr>

            <?php
            $query = oci_parse($conn, "SELECT * FROM CASES ORDER BY ID DESC");
            oci_execute($query);

            while ($row = oci_fetch_assoc($query)) {
                echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['TITLE']}</td>
                        <td>{$row['CASE_TYPE']}</td>
                        <td>{$row['DESCRIPTION']}</td>
                        <td>
                            <form action='actions.php' method='POST'>
                                <input type='hidden' name='delete_id' value='{$row['ID']}'>
                                <button class='delete-btn'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>

        </table>
    </div>

</div>

</body>
</html>
