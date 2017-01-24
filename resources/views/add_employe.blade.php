@include('partials.employeMenue')
<form id='employeForm'>
<div class="grid form-style">
    <div class="row">
        <div class="span12">
            <legend>NEW Employe</legend>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <label>Employe Name</label>
            <div class="input-control text full-size">
                <input type="text" name="name" placeholder="Employe Name">
            </div>
        </div>

        

        <div class="span6">
            <label>ID #</label>
            <div class="input-control text full-size">
                <input type="text" name="id_number" placeholder="787887889">
            </div>
        </div>
    

        
    </div>

    <div class="row">
        
    <div class="span6">
            <label>Employe Father Name</label>
            <div class="input-control text full-size">
                <input type="text" name="father_name" placeholder="Father Name">
            </div>
        </div> 
        
    </div>
    
    <div class="row">
        <div class="span6">
                <label>Contact Info1</label>
                <div class="input-control text full-size">
                    <input type="text" name="contact_1" placeholder="Cell Number 1">
                </div>
        </div>
    
        <div class="span6">
                <label>Contact Infor2</label>
                <div class="input-control text full-size">
                    <input type="text" name="contact_2" placeholder="Cell Num 2">
                </div>
        </div>
    </div>
    
    <div class="row">

        <div class="span6">
            <label>Email</label>
            <div class="input-control text full-size">
                <input type="email" name="email" placeholder="test@gmail.com">
            </div>
        </div>
        <div class="span6">
        <div class="input-control select">
                <label>Employe Designation</label>
                <select name="employe_type_id">
                    <option value="0">Select Type</option>
                     @foreach($et as $c_t)
                        <option value="{{$c_t->id}}">{{$c_t->label}}</option>
                      @endforeach     
                </select>
                
        </div>
        </div>
    
        
    </div>

    <div class="row">
        <div class="input-control textarea">
        <label>Address</label>
          <textarea name="address"></textarea>
        </div>
       
       
    </div>
    
    <div class="form-actions">
    <button type="button" class="button default" onclick="Employe.save()" id="employeFormbtn">Save</button>
    <button type="button" class="button primary" data-link="employe/employees-main" onClick='Utils.loadPage($(this))'>Cancel</button>&nbsp;
        
    </div>
</div>
</form>