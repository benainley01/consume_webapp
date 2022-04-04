<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4640">
        <meta name="description" content="CS4640 Add Transactions Page">  

        <title>Add Transaction</title>

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
                    <h2>Add Transaction</h2>
                    <!-- user_id, name, category, t_date, amount, type -->
                    <?= $error_msg ?>
                    <form action="?command=add" method="post">
                        <div class="mb-3">
                            <label for="transactionName" class="form-label">Transaction</label>
                            <input type="text" class="form-control" id="transactionName" name="transactionName"/>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category"/>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"/>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount"/>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Credit or Debit</label><br>
                            <input type="radio" id="credit" name="type" value="credit">
                            <label for="crdit">Credit</label><br>
                            <input type="radio" id="debit" name="type" value="debit">
                            <label for="debit">Debit</label><br>        
                        </div>   
                        <div class="text-center">                
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>