<style type="text/css">
	.panel-header-bar{
		padding: 10px;
		letter-spacing: 0.01em;
	    color: #fff;
	    font-size: 2.2rem;
	    line-height: 2.2rem;
        background-color: #9a1616;
        margin-bottom: 15px; 	
	}
	.content-data{
		padding: 10px;
		overflow: hidden;
		    border: 1px solid #ccc;
	}
	.content-data .tile.half{
		margin: 5px !important;
		    width: 97px;
    		height: 50px;
	}
	.content-data .tile.half:hover{
		background-color: #9a1616 !important;
		outline: 0;
	}
	.content-data .tile.half .tile-content{
		    text-align: center;
    color: #fff;
    line-height: 45px;
	}
	.table-menu table{
		width: 100%;
	}
	.table-menu table tr th{
		background-color: #9a1616;
		color: #fff;
		padding: 10px;
	    border: 1px solid #ccc;
	    border-top: none;
	    text-align: left;
	}
	.table-menu table tr:nth-child(even){
		background-color: #fff;
	}
	.table-menu table tr:nth-child(odd){
		background-color: #eeeeee;
	}
	.table-menu table tr td{
		padding: 10px;
		    border: 1px solid #ccc;
	}
	.action-btns{
		margin-top: 15px;
	}
	.action-btns button{
		        padding: 10px 0 !important;
    	min-width: 120px;
	}
</style>
<div class="grid fluid">
   <div class="row">
    <!-- Menus  -->
    <div class="span6 ">
    	<div class="panel-header-bar">Menu</div>
    
       <div class="menus table-menu">
       		
       			<div class="content-data">
       				@foreach($cats as $menus)
	                   <div class="tile half bg-cyan cats" cat-id="{{$menus->id}}" cat-name="{{$menus->name}}">
	                        <div class="tile-content icon">
	                            {{$menus->name}}
	                        </div>
	                    </div>
	                   @endforeach
       			</div>

       </div>
       </div>
       
       <!-- Orders Table -->
       <div class="span6 table-menu">
       <div class="panel-header-bar">Orders</div>
        <table class="table striped" border="1" id='my_order'>
      <thead>
       <tr>
        <th>Sr#</th>
        <th>Menu Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Action</th>
       </tr>
      </thead>
      
      <tbody>
    <?php
	    $counters=0;
	    $total=0;
    ?>
     @if(Session::has('Order_Data'))

      	@foreach (Session::get('Order_Data') as $order_detail)
      		<?php
      			$total=$total+$order_detail['menu_price'];
      		?>
      		<tr>
      			<td>{{ ++$counters }}</td>
      			<td>{{ $order_detail['menu_name'] }}</td>
      			<td>{{ $order_detail['menu_qty'] }}</td>
      			<td>{{ $order_detail['menu_price'] }}</td>
      			<td><i class='remove_menu icon-remove'></i></td>
      			
      		</tr>
      	@endforeach
      	<tr><td colspan='4' align='right'><strong>Total:</strong> {{ $total}}</td><td></td></tr>
      @else
       <tr><td colspan="5">No data yet</td></tr>
      @endif
      </tbody>
     </table>
     @if(Session::has('Order_Data'))
     <div class='action-btns btn_removes'><button type=button class='button default' onclick='Order.save_menue_db()' id='btnadd_more'>Confirm for Cock</button>&nbsp;&nbsp;<button type=button class='button default' onclick='Order.remove_ses();' id='btn_cancel_order'>Cancel</button></div>
     @endif
       </div>
   </div>
  </div>
 

			
			

			
			
		

		
			
		