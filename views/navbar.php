<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
        <div class="container-xl bg-dark p-1 aligned-table">
                <a href="main.php" class="navbar-brand">
                    <span class="fw-bold text-light">
                        IMY Eatery
                    </span>
                </a>
                <span class="fw-bold text-light">
                    Hello, <?php echo $userName?>
                </span>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="main.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Modify Menu
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="addDish.php">Add Menu Items</li>
                            <li><a class="dropdown-item" href="addComboMeal.php">Add Combo Meals</li>
                            <li><a class="dropdown-item" href="updateDish.php">Update Menu Items</li>
                            <li><a class="dropdown-item" href="deleteDish.php">Delete Menu Items</li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="genReport.php">Generate Report</li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>