
<html>
<head>
    <title>Manage Posts</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php


    ?>

  <div class="container container--narrow page-section">

    <div class="create-note">
        <h2 class="headline headline--medium">Create New Note</h2>
        <input class="new-note-title" placeholder="Title">
        <textarea class="new-note-body" placeholder="Your note here..."></textarea>
        <span class="submit-note">Create Note</span>
        <span class="note-limit-message">Note limit reached: delete an existing note to make room for a new one.</span>
    </div>

    <ul class="min-list link-list" id="my-notes">
        
    </ul>
    <br>
    <button onclick="getPosts()" >Login</button>
  </div>

        <!-- Scripts -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <!--<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
        
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                setupEvents();
                login();
                setTimeout(() => {
                    getPosts();
                }, 1000);
            });
        </script>
</body>
</html>