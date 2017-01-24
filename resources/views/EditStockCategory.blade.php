@include('partials.stockMenue')
<form id='stockCategoryForm'>
<input type="hidden" name="id" value="{{$cat->id}}">
<div class="grid form-style">
    <div class="row">
        <div class="span12">
            <legend>Edit Menu Category</legend>
        </div>
    </div>

    <div class="row">
       
    
        <div class="span6">
            <label>Category Name</label>
            <div class="input-control text full-size">
                <input type="text" name="name" placeholder="Label" value="{{$cat->name}}">
            </div>
     	</div>
    </div>
    
    
    <div class="form-actions">
        <button type="button" class="button primary nav" data-link="stock/manage-categories">Cancel</button>&nbsp;
        <button type="button" class="button default" onclick="Stock.saveNewStockCategory()" id="btnLogin">Save</button>
    </div>
</div>
</form>