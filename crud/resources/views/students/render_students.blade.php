			<table class="table table-bordered">
	    		<thead>
	    		<tr>
	    			<th width="5%">ID</th>
	    			<th width="15%">Department Name</th>
	    			<th width="10%">Image</th>
	    			<th width="10%">Name</th>
	    			<th width="10%">Email</th>
	    			<th width="10%">Course</th>
	    			<th width="10%">DOB</th>
	    			<th width="10%">Gender</th>
	    			<th width="20%" colspan="3">Action</th>
	    		</tr>
	    	    </thead>
	    	    <tbody>
	    	    	@if(!empty($students))
	    	    	@foreach($students as $key => $student)
	    	    	<tr>
	    	    		<td>{{$student->id}}</td>
	    	    		<td>{{$student->showDepartment->name}}</td>
	    	    		<td><img src = "{{asset($student['image'])}}" id="output" width="70" height="70"/>
	    	    		
	    	    		</td>
	    	    		<td>{{$student->name}}</td>
	    	    		<td>{{$student->email}}</td>
	    	    		<td>{{$student->course}}</td>
	    	    		<td>{{$student->dob}}</td>
	    	    		<td>{{$student->gender}}</td>
	    	    		<td>
	    	    			<button type="button" class="btn btn-success btn-xs" onclick="updateStudent(@php echo $student->id @endphp)">Edit</button>
	    	    			<button type="button" class="btn btn-danger btn-xs" onclick="deleteStudent(@php echo $student->id @endphp)">Delete</button>
	    	    		</td>
	    	    	</tr>
	    	    	@endforeach
	    	    	@else
	    	    	<tr><td colspan="7">No data found</td></tr>@endif
	    	    </tbody>
	    	</table>
	    	<div>
	    		{{$students->links()}}
	    	</div>