@include('partials.stockMenue')
<div class="grid fluid form-style">
	<div class="row">
		<div class="span12">
			<legend>Menus</legend>
			<table class="table bordered" id="dat_table">
				<thead>
					<tr><th>Name</th><th>Full</th>
					<th>Half</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th width="110px">Actions</th></tr>
				</thead>
				<tbody>
                       

                        @foreach($stock as $st)
                        <tr>
                        	<td>{{$st->name}}</td>
                        	<td>{{$st->full}}</td>
                        	<td>{{$st->half}}</td>
                        	<td>{{$st->cat_name}}</td>
                            <td>{{$st->status}}</td>
                        	
                        	
                        	
                            <td>
                            	<button type='button' class='button default' onClick='Stock.showDetails({{$st->id}})'>Edit</button>&nbsp;
                            	<button type='button' class='button warning' onClick='Stock.confirmDelete({{$st->id}})' >Del</button>
  							</td>
                        </tr>
                       @endforeach
                    </tbody>
			</table>
		</div>
	</div> <!-- .row -->
</div>