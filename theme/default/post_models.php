<?php
    ML_header();
?>

        <div class="center-aligned">
            <form enctype="multipart/form-data" class="center-aligned" id="post_model_form" method="post" action="action.php?">
                <input type="hidden" name="method" value="upload">
                <div class="form_input">
                    <p class="form_tag"> <font color="red">* </font> Model File</p>
                    <input type="file" name="model_file">
                </div>
                <div class="form_input">
                    <p class="form_tag"> <font color="red">* </font> Model Name</p>
                    <input class="form_input_text" type="text" name="model_name" placeholder="name">
                </div>
                <div class="form_input">
                    <p class="form_tag"> Model Description</p>
                    <input class="form_input_text" type="text" name="model_desc" placeholder="descrpition">
                </div>
                <div class="form_input">
                    <input type="submit" class="button" name="" value="submit">
                </div>
            </form>
        </div>       
<?php
    ML_footer();
?>