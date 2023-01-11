    <form action="" id="update_form" method="post" enctype="multipart/form-data">
      	@csrf
      	<div class="form-group">
      		<label>Name</label>
      		<input type="text" value="{{$student->name}}" name="name" id="name" class="form-control">
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
      		<select name="department"  id="department" class="form-control">
      			<option value="">Select</option>
      			@foreach($departments as $department)
      			<option value="{{$department->id}}" @if($department->id == $student->department_id) {{'selected'}} @endif
                        >{{$department->name}}</option>
      			@endforeach
      		</select>
      			<span class="text-danger err department"></span>
      	</div>
      	<div class="form-group">
      		<label>Email</label>
      		<input type="text" name="email" value="{{$student->email}}" id="email" class="form-control">
      		<span class="text-danger err email"></span>
      	</div>
      	<div class="form-group">
      		<label>Course</label>
      		<input type="text" name="course" value="{{$student->course}}" id="course" class="form-control">
      		<span class="text-danger err course"></span>
      	</div>
      	<div class="form-group">
      		<label>DOB</label>
      		<input type="date" name="dob" value="{{$student->dob}}"  id="dob" class="form-control">
      		<span class="text-danger err dob"></span>
      	</div>
      	<div class="form-group">
      		<label>Gender</label>
      		<input type="radio" name="gender"
                  @if($student->gender == "Male") {{'checked'}} @endif
                   value="Male">Male
      		<input type="radio" name="gender"
                  @if($student->gender == "Female") {{'checked'}} @endif
                  value="Female">Female
      		<span class="text-danger err gender"></span>
      	</div>

            <div class="form-group">
             <button type="button" name="save" id="save" class="btn btn-primary" onclick="saveUpdatedStudent(@php echo $id @endphp)">Save changes</button>
            </div>
      </form>

      