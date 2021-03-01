<!-- <!DOCTYPE html>
   <html>
   <head>
   	<title>Laravel Category Treeview Example</title>
   	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
       <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      
   </head>
   <body> -->
@extends('layout.admin_master')
@section('content')
 <div class="main-content">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">Manage Category TreeView</div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-6">
               <h3>Category List</h3>
               <ul id="tree1">
                  @foreach($categories as $category)
                  <li>
                     {{ $category->name }}
                     <a  href="{{$category->id}}"  class="btn btn-warning">Edit</a>
                     <a  href="{{$category->id}}"  class="btn btn-danger">Delete</a>
                     @if(count($category->childs))
                     @include('Admin.manageChild',['childs' => $category->childs])
                     @endif
                  </li>
                  @endforeach
               </ul>
            </div>
           
            <div class="col-md-6">
               <div class="row">
                  @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                     <button type="button" class="close" data-dismiss="alert">×</button>	
                     <strong>{{ $message }}</strong>
                  </div>
                  @endif
                  <form class="form-horizontal"  method="POST" action="/add-category" 
                     enctype="multipart/form-data"  >
                     @csrf
                     <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                           {!! Form::label('Category:') !!}
                           {!! Form::select('parent_id',$allCategories, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Category']) !!}
                           <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <div class="controls">
                              <label for="catname">Cat Name</label>
                              <input id="catname" type="text" name="name"
                                 value="{{ old('name') }}" class="form-control"
                                 placeholder="Cat Name" required data-validation-required-message="This Cat Name field is required">
                           </div>
                           @error('name')
                           <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <div class="controls">
                              <label for="catname">Full Description</label>
                              <textarea class="form-control ckeditor" name="description" id="description" rows="5" placeholder="Description" >{{ old('description') }}</textarea>
                           </div>
                           @error('description')
                           <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <div class="controls">
                              <label for="cover">Image</label>
                              <input id="cover" type="file" name="cover" class="form-control" 
                                 required data-validation-required-message="cover image required">
                           </div>
                           @error('cover')
                           <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label for="status">Status</label>
                           <select name="status" id="status" class="form-control controls">
                             
                              <option value="1">Active</option>
                              <option value="0">Deactive</option>
                           </select>
                           @error('status')
                           <div class="alert alert-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <button class="btn btn-success">Add New</button>
                        </div>
                     </div>
                   </form>   
               </div>
            </div>
           
         </div>
      </div>
   </div>
</div>
<style type="text/css">
   .tree, .tree ul {
   margin:0;
   padding:0;
   list-style:none
   }
   .tree ul {
   margin-left:1em;
   position:relative
   }
   .tree ul ul {
   margin-left:.5em
   }
   .tree ul:before {
   content:"";
   display:block;
   width:0;
   position:absolute;
   top:0;
   bottom:0;
   left:0;
   border-left:1px solid
   }
   .tree li {
   margin:0;
   padding:0 1em;
   line-height:2em;
   color:#369;
   font-weight:700;
   position:relative
   }
   .tree ul li:before {
   content:"";
   display:block;
   width:10px;
   height:0;
   border-top:1px solid;
   margin-top:-1px;
   position:absolute;
   top:1em;
   left:0
   }
   .tree ul li:last-child:before {
   background:#fff;
   height:auto;
   top:1em;
   bottom:0
   }
   .indicator {
   margin-right:5px;
   }
   .tree li a {
   text-decoration: none;
   color:#369;
   }
   .tree li button, .tree li button:active, .tree li button:focus {
   text-decoration: none;
   color:#369;
   border:none;
   background:transparent;
   margin:0px 0px 0px 0px;
   padding:0px 0px 0px 0px;
   outline: 0;
   }
</style>
<script type="text/javascript">
   $.fn.extend({
      treed: function (o) {
        
        var openedClass = 'glyphicon-minus-sign';
        var closedClass = 'glyphicon-plus-sign';
        
        if (typeof o != 'undefined'){
          if (typeof o.openedClass != 'undefined'){
          openedClass = o.openedClass;
          }
          if (typeof o.closedClass != 'undefined'){
          closedClass = o.closedClass;
          }
        };
        
          /* initialize each of the top levels */
          var tree = $(this);
          tree.addClass("tree");
          tree.find('li').has("ul").each(function () {
              var branch = $(this);
              branch.prepend("");
              branch.addClass('branch');
              branch.on('click', function (e) {
                  if (this == e.target) {
                      var icon = $(this).children('i:first');
                      icon.toggleClass(openedClass + " " + closedClass);
                      $(this).children().children().toggle();
                  }
              })
              branch.children().children().toggle();
          });
          /* fire event from the dynamically added icon */
          tree.find('.branch .indicator').each(function(){
              $(this).on('click', function () {
                  $(this).closest('li').click();
              });
          });
          /* fire event to open branch if the li contains an anchor instead of text */
          tree.find('.branch>a').each(function () {
              $(this).on('click', function (e) {
                  $(this).closest('li').click();
                  e.preventDefault();
              });
          });
          /* fire event to open branch if the li contains a button instead of text */
          tree.find('.branch>button').each(function () {
              $(this).on('click', function (e) {
                  $(this).closest('li').click();
                  e.preventDefault();
              });
          });
      }
   });
   /* Initialization of treeviews */
   $('#tree1').treed();
</script>
</div>
<!-- </body>
   </html>
    -->
@endsection