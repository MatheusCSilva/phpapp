<?php

require_once(__DIR__ . '/vendor/autoload.php');

include("lib/Api/EmployeesApiControllerApi.php");
include("lib/Model/Employee.php");
// define variables and set to empty values
$nameErr = $idErr = $titleErr = "";

$name = $id = $title = "";
$apiInstance = new Swagger\Client\Api\EmployeesApiControllerApi(new GuzzleHttp\Client());


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    if ($action == "add")
    {     // adiciona
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";

        } else {
            $name =$_POST["name"];
        }
        if (empty($_POST["title"])) {
            $titleErr = "Title is required";
        } else {
            $title = $_POST["title"];
        }
        if (empty($_POST["id"])) {
            $idErr = "ID is required";
        } else {
            $id = $_POST["id"];
        }

        $body = new \Swagger\Client\Model\Employee();
        $body->setEmployeeName($name);
        $body->setEmployeeTitle($title);
        $body->setId($id);
        try {

            $apiInstance->employeesPost($body);
            $emp = $apiInstance->employeesIdGet($id);
        } catch (Exception $e) {
            echo 'Exception when calling EmployeesApiControllerApi->employeesPost: ', $e->getMessage(), PHP_EOL;
        }

    } else if ($action == "del")
    {
        if (empty($_POST["id"])) {
            $idErr = "ID is required";
        } else {
            $id = $_POST["id"];
        }
        echo "ID to delete: " . $id;
        try {
            $result = $apiInstance->employeesIdDelete($id);
        } catch (Exception $e) {
            echo 'Exception when calling EmployeesApiControllerApi->employeesIdDelete: ', $e->getMessage(), PHP_EOL;
        }
    } else if ($action == "edit"){
        //edit
        if (empty($_POST["id"])) {
            $idErr = "ID is required";
        } else {
            $id = $_POST["id"];
        }
        try {
            $result = $apiInstance->employeesIdDelete($id);
        } catch (Exception $e) {
            echo 'Exception when calling EmployeesApiControllerApi->employeesIdDelete: ', $e->getMessage(), PHP_EOL;
        }
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name =$_POST["name"];
        }
        if (empty($_POST["title"])) {
            $titleErr = "Title is required";
        } else {
            $title = $_POST["title"];
        }
        if (empty($_POST["id"])) {
            $idErr = "ID is required";
        } else {
            $id = $_POST["id"];
        }
        $body1 = new \Swagger\Client\Model\Employee();
        $body1->setEmployeeName($name);
        $body1->setEmployeeTitle($title);
        $body1->setId($id);
        try {
            $apiInstance->employeesPost($body1);
            $emp1 = $apiInstance->employeesIdGet($id);
        } catch (Exception $e) {
            echo 'Exception when calling EmployeesApiControllerApi->employeesPost: ', $e->getMessage(), PHP_EOL;
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <title>UnitTest</title>
    </head>

    <body>

        <?php

        if (empty($_GET["IdGet"])){
            echo "";
        }else {
            $id = $_GET["IdGet"];
            try {
                $result = $apiInstance->employeesIdGet($id);
                $idget = $result->getId($id);
                $empName = $result->getEmployeeName();
                $empTitle = $result->getEmployeeTitle();
                echo "<table id='t01'>\n" .
                    "<tr>\n".
                    "<th>ID: </th>\n" .
                    "<th>Name: </th>\n" .
                    "<th>Title: </th>\n" .
                    "</tr>\n".
                    "<tr>\n".
                    "<td>$idget</td>\n" .
                    "<td> $empName</td>\n".
                    "<td>$empTitle</td>\n" .
                    "</tr>\n".
                    "</table>\n";
            } catch (Exception $e) {
                echo 'Exception when calling EmployeesApiControllerApi->employeesIdDelete: ', $e->getMessage(), PHP_EOL;
            }
        }

        ?>
        <div class="contain">
            <div class="row">
                <div class="col-sm-5">
                    <div class="insideList">
                        <center>
                            <h5>Employees List</h5>
                        </center>
                        <p>
                            <?php
                            $body_limit = 56; // int | The amount of employees returned
                            $page_limit = 5; // int | The pages to  return employees info

                            $result = $apiInstance->employeesGet($body_limit, $page_limit);
                            foreach ($result as list("id" => $idLis, "employee_name" => $nameLis, "employee_title" => $titleLis )) {
                                echo "<table id='t01'>\n" .
                                    "<form method='GET' id='my_form' action='index.php'></form>".
                                    "<tr>\n".
                                    "<th id='idlist'><center>ID:</center> </th>\n" .
                                    "<th>Name: </th>\n" .
                                    "<th>Title: </th>\n" .
                                    "</tr>\n".
                                    "<tr>\n".
                                    "<td><strong><center><input type='text' name='company' form='my_form' readonly class='form-control-plaintext' value='$idLis' size='3'/></center></strong></td>\n" .
                                    "<td>$nameLis</td>\n" .
                                    "<td>$titleLis</td>\n" .
                                    "</tr>\n".
                                    "</table>\n";
                            }

                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-12 getEmp">
                        <div class="insideCol">
                            <center>
                                <h5>Create new employee</h5>
                            </center>
                            <div class="getInside" style="padding: 5px; transform: scale(0.9)">
                                <form method="post" action="index.php">

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="id" class="form-control"
                                                   id="exampleFormControlInput1" placeholder="Insert Employee ID" required>
                                            <div class="invalid-feedback">
                                                ID required!!
                                            </div>
                                        </div>
                                    </div>
                                    <span class="error"><?php echo $idErr; ?></span>
                                    <div class="form-group row">
                                        <label for="InputName" class="col-sm-2 col-form-label"> Name: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="InputName" name="name"
                                                   placeholder="Insert Employee name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="InputTitle" class="col-sm-2 col-form-label"> Title: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="InputTitle" name="title"
                                                   placeholder="Insert Employee title">
                                        </div>
                                    </div>

                                    <input type="hidden" name="action" value="add" />
                                    <input type="submit" name="submit" value="Submit" class="btn btn-outline-success">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 getEmp">
                        <div class="insideCol">
                            <center>
                                <h5>Edit employee</h5>
                            </center>
                            <div class="getInside" style="padding: 5px; transform: scale(0.9)">
                                <form method="post" action="index.php">

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="id" class="form-control"
                                                   id="exampleFormControlInput1" placeholder="Insert Employee ID" required>
                                            <div class="invalid-feedback">
                                                ID required!!
                                            </div>
                                        </div>
                                    </div>
                                    <span class="error"><?php echo $idErr; ?></span>
                                    <div class="form-group row">
                                        <label for="InputName" class="col-sm-2 col-form-label"> Name: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="InputName" name="name"
                                                   placeholder="Insert Employee name">
                                        </div>
                                    </div>
                                    <span class="error"><?php echo $nameErr; ?></span>
                                    <div class="form-group row">
                                        <label for="InputTitle" class="col-sm-2 col-form-label"> Title: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="InputTitle" name="title"
                                                   placeholder="Insert Employee title">
                                        </div>
                                    </div>
                                    <span class="error"><?php echo $titleErr; ?></span>
                                    <input type="hidden" name="action" value="edit" />
                                    <input type="submit" name="submit" value="Submit" class="btn btn-outline-success">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="insideCol">
                            <center>
                                <h5>Delete Employee (by ID)</h5>
                            </center>
                            <div class="getInside" style="padding: 5px; transform: scale(0.9)">
                                <form method="post" action="index.php">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="id" class="form-control"
                                                   id="exampleFormControlInput1" placeholder="Insert Employee ID" required>
                                            <div class="invalid-feedback">
                                                ID required!!
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" name="action" value="del" />
                                    <input type="submit" name="submit" value="Delete" class="btn btn-outline-danger">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="insideCol">
                            <center>
                                <h5>Get by ID</h5>
                            </center>
                            <form action="index.php">
                                <div class="getInside" style="padding: 5px; transform: scale(0.9)">
                                    <div class="form-group row">
                                        <label for="IdGet" class="col-sm-2 col-form-label">ID:</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="IdGet" class="form-control"
                                                   id="exampleFormControlInput1" placeholder="Insert Employee ID">
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" name="action" value="getId">
                                    <input type="submit" value="Get by ID" class="btn btn-outline-success" required>
                                    <div class="invalid-feedback">
                                        ID required!!
                                    </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>
        </div>



        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
                integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
                integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
        </script>

    </body>

</html>