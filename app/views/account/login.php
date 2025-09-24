    <h4 class="tx-inverse tx-center">Log In</h4>
    <p class="tx-center mg-b-30">*Use your Windows Active Directory Access</p>
    <div class="row">
        <div class="col-md-12">
            <?php flash(promptMessage('message')); ?>
        </div>
    </div>
    <form id="form" method="post">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Username" value="<?php echo multiArrayKeyExist($data, 'post', 'username'); ?>">
            <?php echo multiArrayKeyExist($data, 'error', 'username'); ?> 
        </div>

        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <?php echo multiArrayKeyExist($data, 'error', 'password'); ?>                    
        </div>

        <button name="submit" type="submit" class="btn btn-info btn-block">Sign In</button>
    </form>
    <hr>
    <div class="mg-t-10">
        <p>
            Need help? Please Contact Service Desk
        </p>
        <p>
            Email: <b><a href="mailto:servicedesk@fpgins.com" class="tx-primary">servicedesk@fpgins.com</a></b>
            <br>
            Direct Line: <b><a class="tx-primary">8501</a></b> to <b><a class="tx-primary">8503</a></b>
        </p>
    </div>