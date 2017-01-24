@include('partials.stockMenue')
<form id='stockForm'>
<div class="grid form-style">
    <div class="row">
        <div class="span12">
            <legend>New Menu</legend>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <label>Type</label>
            <div class="input-control select">
                <select name="cat_id">
                    <option value="0">Select Category</option>
                     @foreach($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                      @endforeach     
                </select>
            </div>
     	</div>

        
    </div>
    
    <div class="row">
        <div class="span6">
                <label>Menu Name</label>
                <div class="input-control text full-size">
                    <input type="text" name="name" placeholder="Chicken Handi">
                </div>
        </div>
    
        <div class="span6">
                
                

     	</div>
    </div>
    
    <div class="row">
        <div class="span6">
                <label>Full</label>
                <div class="input-control text full-size">
                    <input type="text" name="full" placeholder="Price">
                </div>
        </div>
    
        <div class="span6">
                <label>Half</label>
                <div class="input-control text full-size">
                    <input type="text" name="half" placeholder="Price">
                </div>
        </div>
    </div>

    
    
    <div class="form-actions">
    <button type="button" class="button primary" data-link="stock/manage-stock" onClick='Utils.loadPage($(this))'>Cancel</button>&nbsp;
        <button type="button" class="button default" onclick="Stock.save()" id="btnLogin">Save</button>
    </div>
</div>
</form>