@include('partials.stockMenue')
<div class="grid fluid form-style">
	<div class="row">
		<div class="span12">
			<legend>Menu Categories</legend>
			<table class="table bordered" id="data_table">
				<thead>
					<tr><th>id</th><th>Nmae</th>
					<th width="110px">Actions</th></tr>
				</thead>
				<tbody>
                       

                        @foreach($cats as $cat)
                        <tr>
                        	<td>{{$cat->id}}</td>
                        	<td>{{$cat->name}}</td>
                            <td>
                            	<button type='button' class='button default' onClick='Stock.showStockCategory({{$cat->id}})'>Edit</button>&nbsp;
                            	
  							</td>
                        </tr>
                       @endforeach
                    </tbody>
			</table>
		</div>
	</div> <!-- .row -->
</div>