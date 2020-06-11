<html>

<head>
   <title>Upload Debug Form</title>
   <style>
      .err {
         text-align: center;
         font-size: 24px;
         color: red;
      }
   </style>
</head>

<body>
   <div class="err">
      <?php echo $error; ?>
   </div>
   <!-- <?php echo form_open_multipart('upload/do_upload'); ?> -->
   <!-- <form action="">
      <input type="file" name="userfile" size="20" /><br>
      <input type="submit" value="upload" />
   </form> -->

</body>

</html>