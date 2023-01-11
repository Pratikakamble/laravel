@extends('layouts.master')
@section('content')
	<div class="container">
	  <div class="panel panel-default">
	    <div class="panel-heading mt-3 mb-3" align="right">
	    	<div class="row">
	    		<div class="col-md-6" align="left"><h4>Student Data</h4></div>
	    		<div class="col-md-6" align="right">
	    			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Student</button>
	    		</div>
	    	</div>
	    	<hr>
	    	<div class="row mt-2">
	    		<div class="col-md-6" align="left">
	    			<div class="row">
	    				<div class="col-md-1">Show</div>
	    				<div class="col-md-2">
	    					<select name="limit" class="form-control" id="limit" >
	    						<option value="5">5</option>
	    						<option value="10">10</option>
	    						<option value="25">25</option>
	    						<option value="50">50</option>
	    					</select>
	    				</div>
	    			</div>
	    		</div>
	    		<div class="col-md-6" align="right">
	    			<div class="row">
	    				<div class="offset-md-6 col-md-2">Search</div>
	    				<div class="col-md-4">
	    					<input type="text" class="form-control" id="keyword" name="keyword">
	    				</div>
	    				
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class="panel-body" id="render_student">
	    	
	    </div>

	  
	  </div>
	</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" id="close_modal">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" id="student_form" method="post" enctype="multipart/form-data">
      	@csrf
      	<div class="form-group">
      		<label>Name</label>
      		<input type="text" name="name" id="name" class="form-control">
      		<span class="text-danger err name"></span>
      	</div>
      	<div class="form-group">
                  <label>Image</label>
                  <img style="display:none;" src="" id="preview" width="50px" height="50px">
                  <input type="file" name="image" id="image" class="form-control" onchange="imagePreview(event)">
                  <span class="text-danger err image"></span>
        </div>
      	<div class="form-group">
      		<label>Department</label>
      		<select name="department" id="department" class="form-control">
      			<option value="">Select</option>
      			@foreach($departments as $department)
      			<option value="{{$department->id}}">{{$department->name}}</option>
      			@endforeach
      		</select>
      			<span class="text-danger err department"></span>
      	</div>
      	<div class="form-group">
      		<label>Email</label>
      		<input type="text" name="email" id="email" class="form-control">
      		<span class="text-danger err email"></span>
      	</div>
      	<div class="form-group">
      		<label>Course</label>
      		<input type="text" name="course" id="course" class="form-control">
      		<span class="text-danger err course"></span>
      	</div>
      	<div class="form-group">
      		<label>DOB</label>
      		<input type="date" name="dob" id="dob" class="form-control">
      		<span class="text-danger err dob"></span>
      	</div>
      	<div class="form-group">
      		<label>Gender</label>
      		<input type="radio" name="gender" value="Male">Male
      		<input type="radio" name="gender" value="Female">Female
      		<span class="text-danger err gender"></span>
      	</div>

      	<div class="form-group">
      	 <button type="button" name="save" id="save" class="btn btn-primary" onclick="saveStudent()">Save changes</button>
      	</div>
      </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" id="update_close_modal">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>



@endsection

@section('script')
<script>
	$(document).ready(function(){
		loadData(null, limit, null);
	})
	var limit = 5;
	var keyword = $('#keyword').val();
	$('#limit').change(function(){
		limit = $(this).val();
		loadData(null, limit, null);
	})
	function loadData(page=null, limit=null, keyword){
		$.ajax({
			url:"{{route('students')}}",
			type:'get',
			data:{page:page, limit:limit, keyword:keyword},
			success:function(data){
				$('#render_student').html(data);
			}
		})
	}

	$(document).on('click', '.pagination a', function(e){
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		loadData(page,limit,keyword);
	});

	$('#keyword').keyup(function(){
		loadData(null,limit,$(this).val());
	})

	function saveStudent(){
		var elm = $('#student_form')[0];
		var fd = new FormData(elm);
		$.ajax({
			url:"{{route('savestudents')}}",
			type:'post',
			data:fd,
			processData:false,
			contentType:false,
			success:function(data){
				if(data['status'] == 'success'){
					swal("Good job!", data['message'], "success");
					$('#close_modal').trigger('click');
					loadData(null, limit, null);
				}else{
				if(data['errors'] != ""){
					$('.err').text('');
					console.log(data['errors']);
					$('#student_form input').each(function(){
						var classname = $(this).attr('id');
						var name = $(this).attr('name');
						$('.'+classname).text(data['errors'][name]);
					});
					$('#student_form .department').text(data['errors']['department']);
					$('#student_form .gender').text(data['errors']['gender']);
				}
			}
			}
		})
	}

	function updateStudent(id){
		$('#updateModal .modal-body').html('');
		$.ajax({
			url:"/edit-student/"+id,
			type:'get',
			success:function(data){
				$('#updateModal').modal('show');
				$('#updateModal .modal-body').html(data);
			}
		})
	}

	function saveUpdatedStudent(id){
		var fd = new FormData($('#update_form')[0]);
		$.ajax({
			url:"/update-student/"+id,
			type:'post',
			data:fd,
			processData:false,
			contentType:false,
			success:function(data){
				if(data['status'] == 'success'){
					//alert(data['message']);
					swal("Good job!", data['message'], "success");
					$('#update_close_modal').trigger('click');
					$('#update_form')[0].reset();
					$('#update_form .err').text('');
					loadData(null, limit, null);
				}else{
				if(data['errors'] != ""){
					$('.err').text('');
					console.log(data['errors']);
					$('#update_form input').each(function(){
						var classname = $(this).attr('id');
						var name = $(this).attr('name');
						$('.'+classname).text(data['errors'][name]);
					});
					$('#update_form .department').text(data['errors']['department']);
					$('#update_form .gender').text(data['errors']['gender']);
				}
			}
			}
		})
	}

		function deleteStudent(id){
		$('.modal-body').html('');
		$.ajax({
			url:"/delete-student/"+id,
			type:'get',
			success:function(data){
				//alert(data['message']);
				swal("Good job!", data['message'], "success");
				loadData(null, limit, null);
			}
		})
	}

	 function imagePreview(e){
                  var img = URL.createObjectURL(e.target.files[0]);
                  if(img != ""){
                     $('#preview').show();
                     $('#preview').attr('src', img);
                  }else{
                     $('#preview').hide();
                  }
                  
            }
</script>
@endsection