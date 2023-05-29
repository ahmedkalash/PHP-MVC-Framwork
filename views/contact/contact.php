
<h1>Contact us <?php echo $firstName , $lastName; ?></h1>

<?php echo "you are " . $firstName; ?>
<form action="/contact" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Subject</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="subject">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Message</label>
        <textarea  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="message"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
