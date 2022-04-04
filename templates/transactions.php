<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4640">
        <meta name="description" content="CS4640 Transactions Page">  

        <title>Transactions</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <nav class="navbar navbar-light bg-light border rounded-3 p-3">
                    <h2><a href="?command=transactions" style="text-decoration: none;">CS4640 Finance Tracker</a></h2>
                    <h5>Hello <?=$_SESSION["name"]?>!</h5>
                    <h6><?=$_SESSION["email"]?></h6>
                    <form class="form-inline">
                        <a href="?command=addTransaction" role="button" class="btn btn-outline-success">Add Transaction</a>
                        <a href="?command=logout" role="button" class="btn btn-outline-danger">Logout</a>
                    </form>
                </nav>
            </div>
            <br>
            <div class="row col-xs-8">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <?= $error_msg ?>
                    <h2 class="text-center">Current Balance: $<?= $balance ?></h2>
                    
                    <h2>Transactions</h2>
                        <table class = "table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactions as $transaction): ?>
                                <tr>
                                    <td><?= $transaction["name"]; ?></td>
                                    <td><?= $transaction["category"]; ?></td>
                                    <td><?= $transaction["t_date"]; ?></td>
                                    <td><?= $transaction["amount"]; ?></td>
                                    <td><?= $transaction["type"]; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <br>
                    <h2>Category Totals</h2>
                        <table class = "table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Category</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($categoryInfo as $row): ?>
                                    <tr>
                                        <td><?= $row["category"]; ?></td>
                                        <td><?= $row["balance"]; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                        </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>