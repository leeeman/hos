@include('partials.employeMenue')
<form id='employeForm'>
<div class="grid form-style">
    <div class="row">
        <div class="span12">
            <legend>Add App User</legend>
        </div>
    </div>

    <div class="row">
        <div class="span6">
        <div class="input-control select span6">
                <label>Employe</label>
                <select name="emp_id">
                    <option value="0">Select Employe</option>
                     @foreach($employe as $c_t)
                        <option value="{{$c_t->id}}">{{$c_t->name}}</option>
                      @endforeach     
                </select>
                
        </div>
        </div>
        <div class="span6">
        <div class="input-control select">
                <label>Employe Role</label>
                <select name="role_id">
                    <option value="0">Select Role</option>
                     @foreach($emp_role as $c_t)
                        <option value="{{$c_t->id}}">{{$c_t->full_name}}</option>
                      @endforeach     
                </select>
                
        </div>
        </div>
        
    </div>

    <div class="row">
        <div class="span6">
            <label>Employe Username</label>
            <div class="input-control text full-size">
                <input type="text" name="username" placeholder="Username">
            </div>
        </div>

        <div class="span6">
            <label>Password</label>
            <div class="input-control text full-size">
                <input type="password" name="password">
            </div>
        </div>
    
        
    </div>
    
   
    
    
    
    <div class="form-actions">
    <button type="button" class="button default" onclick="Employe.saveAppUser()" id="employeFormbtn">Save</button>
    <button type="button" class="button primary" data-link="employe/employees-main" onClick='Utils.loadPage($(this))'>Cancel</button>&nbsp;
        
    </div>
</div>
</form>