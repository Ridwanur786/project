﻿<?php require_once __DIR__."/../../vendor/autoload.php";?>
<?php include __DIR__."/../admin/Inc/adminHeader.php";?>
<?php include __DIR__."/../admin/Inc/adminSidebar.php";
 //$user = Session::get('username');
?>
    <div class="grid_10">
        <div class="box round first grid">
            <h2>Add New Post</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            $title = mysqli_real_escape_string($db->link, $_POST['title']);
            $cat = mysqli_real_escape_string($db->link, $_POST['cat']);
            $body = mysqli_real_escape_string($db->link, $fm->validation($_POST['body']));
            $tags = mysqli_real_escape_string($db->link, $_POST['tags']);
            $author = mysqli_real_escape_string($db->link, $_POST['author']);
            $userId = mysqli_real_escape_string($db->link, $_POST['userid']);
           // $uploaded_img = mysqli_real_escape_string($db->link, $_POST['image']);

            $permited  = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['img']['name'];
            $file_size = $_FILES['img']['size'];
            $file_temp = $_FILES['img']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "../upload/".$unique_image;

            if($title== ""|| $cat== ""|| $body == ""|| $tags == ""|| $author == ""|| $file_name == "")
            {
                echo "<span>Field Must Not Be empty!!</span>";
            }
           elseif ($file_size >1048567) {
                echo "<span class='error'>Image Size should be less then 1MB!
     </span>";
            } elseif (in_array($file_ext, $permited) === false) {
                echo "<span class='error'>You can upload only:-"
                    .implode(', ', $permited)."</span>";
            } else{
                move_uploaded_file($file_temp, $uploaded_image);
                $query = " INSERT INTO tbl_post(title,body,img,tags,author,cat,userid) 
    VALUES('$title','$body','$uploaded_image','$tags','$author','$cat','$userId')";
                $inserted_rows = $db->insert($query);
                if ($inserted_rows) {
                    echo "<span class='success'>Data Inserted Successfully.
     </span>";
                }else {
                    echo "<span class='error'>Data Not Inserted !</span>";
                }
            }
        }
        ?>
            <div class="block">
                <form action="addpost.php" method="post" enctype="multipart/form-data">
                    <table class="form">
                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td>
                                <input type="text" name="title" placeholder="Enter Post Title..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Category</label>
                            </td>
                            <td>
                                <select id="select" name="cat">
                                    <option>select category</option>
                                    <?php
                                    $query = "SELECT * FROM `tbl_category`";
                                 $category = $db->select($query);
                                    if ($category )
                                    {
                                        while($result = $category->fetch_assoc())
                                        {
                                    ?>
                                            <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                                  <?php    }
                                    }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Image</label>
                            </td>
                            <td>
                                <input type="file" name="img" />
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; padding-top: 9px;">
                                <label>Content</label>
                            </td>
                            <td>
                                <textarea class="tinymce" name="body"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tags</label>
                            </td>
                            <td>
                                <input type="text" name="tags" placeholder="Enter Tags Title..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>author</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo Session::get("username");?>" name="author" class="medium"/>
                                <input type="hidden" value="<?php echo Session::get("userId");?>" name="userid" class="medium"/>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<?php include __DIR__."/../admin/Inc/adminFooter.php";?>

