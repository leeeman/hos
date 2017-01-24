@include('partials.stockMenue')
<form id='stockCategoryForm'>
<div class="grid form-style">
    <div class="row">
        <div class="span12">
            <legend>New Menu Category</legend>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <label>Category Name</label>
            <div class="input-control text full-size">
                <input type="text" name="name" placeholder="Category Label">
            </div>
     	</div>
    </div>
    
    
    <div class="form-actions">
        <button type="button" class="button primary nav" data-link="stock/stock-category-main">Cancel</button>&nbsp;
        <button type="button" class="button default" onclick="Stock.saveNewStockCategory()" id="btnLogin">Save</button>
    </div>
</div>
</form>