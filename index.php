<?php
include_once 'class.imageEncode.php';

if (isset($_FILES["file"])) {
    if ($_FILES["file"]["error"] !== 0) {
        $err = print_r($_FILES, true);
    } else {
        $imgsrc = new imageEncode($_FILES["file"]["tmp_name"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Image Encoder Example</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="content">
            <div class="inputblock">
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="file">Image:</label>
                    <input type="file" name="file" id="file"><br><br>
                    <input class="btn" type="submit" name="submit" value="Submit">
                </form>
            </div>
            <div class="inputblock" >
                <table cellspacing='5' cellpadding='5' width="100%">
                    <tr>
                        <td>
                            <ul>
                                <?php
                                if (isset($imgsrc)) {
                                    echo "<li>File Size:" . $imgsrc->getFileSize() . "</li>";
                                    echo "<li>Mime Type:" . $imgsrc->getMimeType() . "</li>";
                                    echo "<li>Image Height:" . $imgsrc->getImageHeight() . "</li>";
                                    echo "<li>Image Width:" . $imgsrc->getImageWidth() . "</li>";
                                }
                                ?>
                            </ul>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea cols="40" rows="40"><?php echo $imgsrc->getImageHtml() ?></textarea> 
                        </td>
                        <td>
                            <textarea cols="40" rows="40"><?php echo $imgsrc->getImageCSS("imagecss") ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $imgsrc->getImageHtml("Trees",.5) ?></td>
                    </tr>
                </table>    
            </div>
        </div>
    </body>
</html>

