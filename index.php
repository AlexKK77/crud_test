<!DOCTYPE html>
<html>
<head>
    <title>Phone book</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include('action.php'); ?>
    <h1>Phone book</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)){?>
                <tr>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["phone"]; ?></td>
                    <td><a class="btn-edit" href="index.php?edit=<?php echo $row["id"]?>">edit</a></td>
                    <td><a class="btn-del" href="index.php?del=<?php echo $row["id"]?>">del</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if(isset($_SESSION['msg'])){?>
        <div class="msg">
            <?php echo $_SESSION['msg'];
            unset($_SESSION['msg']); ?>
        </div>
    <?php }?>
    <form class="book-form" method="post" action="action.php">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <div class="book-form__item">
            <label>Name</label>
            <input class="book-form__input" type="text" name="name" value="<?php echo $name; ?>">
        </div>
        <div class="book-form__item">
            <label>Phone</label>
            <input class="book-form__input" type="text" onkeypress='validate(event)' name="phone" value="<?php echo $phone; ?>">
        </div>
        <div class="book-form__item">
            <?php if ($update == true){ ?>
                <button class="book-form__btn" type="submit" name="update">Update</button>
                <button class="book-form__btn book-form__btn_new" type="submit" name="new">New</button>
            <?php }else{ ?>
                <button class="book-form__btn" type="submit" name="add">Add</button>
                <button class="book-form__btn book-form__btn_search" type="submit" name="search">Search</button>
            <?php } ?>
        </div>
    </form>
    <?php if(isset($_SESSION['sid'])){ ?>
        <h2>Search results</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['sid'] as $row_search) {?>
                    <tr>
                        <td><?php echo $row_search["name"]; ?></td>
                        <td><?php echo $row_search["phone"]; ?></td>
                        <td><a class="btn-edit" href="index.php?edit=<?php echo $row_search["id"]?>">edit</a></td>
                        <td><a class="btn-del" href="index.php?del=<?php echo $row_search["id"]?>">del</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    <script type="text/javascript">
        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]/;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
</body>
</html>