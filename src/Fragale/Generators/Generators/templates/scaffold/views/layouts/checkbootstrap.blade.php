<!DOCTYPE html>
<html lang="en">
    <link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <body>      
        <div id="page-container">
            <div class="container-fluid">
            <button type="button" class="btn btn-success btn-lg">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span> This button have a star?
            </button>
            </div>          
        </div>

<div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img data-src="holder.js/100%x100%" alt="select">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
  <div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="test"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>
 <script src="https://code.jquery.com/jquery.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    </body> 
</html>
