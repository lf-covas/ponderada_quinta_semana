<?php 
require "./dbinfo.inc"; 
?>
<html>
<body>
<h1>Cadastro</h1>
<?php

    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);

    /* Ensure that the EMPLOYEES table exists. */
    VerifyEmployeesTable($connection, DB_DATABASE);

    /* If input fields are populated, add a row to the EMPLOYEES table. */
    $employee_name = htmlentities($_POST['NAME']);
    $employee_address = htmlentities($_POST['ADDRESS']);

    if (strlen($employee_name) && strlen($employee_address)) {
        AddEmployee($connection, $employee_name, $employee_address);
    }

    /* Ensure that the EMPLOYEES table exists. */
    VerifyDataEmployeesTable($connection, DB_DATABASE);

    /* If input fields are populated, add a row to the EMPLOYEES table. */
    $employee_cpf = htmlentities($_POST['CPF']);
    $employee_idade = intval($_POST['IDADE']);
    $employee_birth_date = date('Y-m-d', strtotime($_POST['BIRTH_DATE']));
    $employee_married = $_POST['MARRIED'];

    $marriedValue = ($employee_married === "Sim") ? 1 : 0;
  
    if (strlen($employee_cpf) && strlen($employee_idade ) && strlen($employee_birth_date) && strlen($employee_married)){
      AddDataEmployee($connection, $employee_cpf, $employee_idade, $employee_birth_date, $marriedValue);
    }
?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADRESS</td>
      <td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="ADDRESS" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="CADASTRAR" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
?>

</table>
<br>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
        <td>CPF</td>
        <td>IDADE</td>
        <td>BIRTH DATE</td>
        <td>MARRIED</td>
    </tr>
    <tr>
      <td>
        <input type="number" name="CPF" maxlength="11" size="11" />
      </td>
      <td>
        <input type="text" name="IDADE" maxlength="90" size="60" />
      </td>
      <td>
        <input type="date" name="BIRTH_DATE"/>
      </td>
      <td>
        <select name="MARRIED">
            <option value="Sim">Sim</option>
            <option value="Não">Não</option>
        </select>
      </td>
      <td>
        <input type="submit" value="CADASTRAR" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>CPF</td>
    <td>IDADE</td>
    <td>BIRTH DATE</td>
    <td>MARRIED</td>
  </tr>

<?php

$result2 = mysqli_query($connection, "SELECT * FROM DATA_EMPLOYEES");

while($query_data2 = mysqli_fetch_row($result2)) {
  echo "<tr>";
  echo "<td>",$query_data2[0], "</td>",
       "<td>",$query_data2[1], "</td>",
       "<td>",$query_data2[2], "</td>",
       "<td>",$query_data2[3], "</td>",
       "<td>",$query_data2[4], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_free_result($result2);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Add an employee to the table. */
function AddDataEmployee($connection, $cpf, $idade, $birth_date, $married) {
    $p = mysqli_real_escape_string($connection, $cpf);
    $u = mysqli_real_escape_string($connection, $idade);
    $t = mysqli_real_escape_string($connection, $birth_date);
    $o = mysqli_real_escape_string($connection, $married);
 
    $query = "INSERT INTO DATA_EMPLOYEES (CPF, IDADE, BIRTH_DATE, MARRIED) VALUES ('$p', '$u','$t', '$o');";
 
    if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
 }

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check whether the table exists and, if not, create it. */
function VerifyDataEmployeesTable($connection, $dbName) {
    if(!TableExists("DATA_EMPLOYEES", $connection, $dbName))
    {
        $query = "CREATE TABLE DATA_EMPLOYEES (
            id_data_employees int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            CPF VARCHAR(11),
            IDADE int(3),
            BIRTH_DATE DATE,
            MARRIED TINYINT
          )";
  
       if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
    }
  }

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}

?> 