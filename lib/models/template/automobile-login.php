<?php
 /*Template Name: checkout
 */
 
 $automobile_options = get_option('automobile_options');
 
get_header(); ?>
<div style="height: 200px;"></div>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-6">
          
       <form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email Address *</label>
  <div class="controls">
    <input id="email" name="email" placeholder="Email Address " class="form-control" type="text">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="passwordinput">Password</label>
  <div class="controls">
    <input id="passwordinput" name="passwordinput" placeholder="placeholder" class="form-control" required="" type="password">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">First Name</label>
  <div class="controls">
    <input id="textinput" name="textinput" placeholder="First Name" class="form-control" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="last_name">Last Name</label>
  <div class="controls">
    <input id="last_name" name="last_name" placeholder="Last Name" class="form-control" type="text">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="address">Address</label>
  <div class="controls">                     
    <textarea id="address" class="form-control" name="address">Address</textarea>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone ">Phone </label>
  <div class="controls">
    <input id="phone " name="phone " placeholder="Phone " class="form-control" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Select Basic</label>
  <div class="controls">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option>Option one</option>
      <option>Option two</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="postcode">Postcode / Zip</label>
  <div class="controls">
    <input id="postcode" name="postcode" placeholder="Postcode / Zip" class="form-control" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="town_city">Town / City</label>
  <div class="controls">
    <select id="town_city" name="town_city" class="form-control">
      <option>Option one</option>
      <option>Option two</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="Notes ">Notes </label>
  <div class="controls">                     
    <textarea  class="form-control" id="Notes " name="Notes ">Notes </textarea>
  </div>
</div>



</fieldset>
</form>
    </div>
    <div class="col-sm-6 col-md-6">
    <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                          
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">Product name</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                               
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <span>5</span>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$4.87</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$14.61</strong></td>
                       
                    </tr>
                    <tr>
                        <td class="col-md-6">
                        <div class="media">
                            
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">Product name</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                               
                            </div>
                        </div></td>
                        <td class="col-md-1" style="text-align: center">
                        <span>5</span>
                        </td>
                        <td class="col-md-1 text-center"><strong>$4.99</strong></td>
                        <td class="col-md-1 text-center"><strong>$9.98</strong></td>
                       
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong>$24.59</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Estimated shipping</h5></td>
                        <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>$31.53</strong></h3></td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="control-group pull-right">
  <label class="control-label" for="Place order">Place order</label>
  <div class="controls">
    <button id="Place order" name="Place order" class="btn btn-primary">Place order</button>
  </div>
</div>
            </div>
            <!-- Button -->

        </div>

    

  <div class="row">
  
</div>
</div>
<?php get_footer(); ?>       
              