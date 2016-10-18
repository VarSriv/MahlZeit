<div class="container">
  <div class="panel">
    <h1>Sign Up with Mahlzeit</h1>
    <p>Signing up helps you keep up to date with latest information on cuisines and restaurants of your choice, and also lets you write reviews</p>
    <?php if(isset($resultmessg))echo $resultmessg; ?>
    <form method="post" onsubmit="return handlesignup(event)">
      <table style="margin:auto;">
        <tr>
          <td><label>Name</label></td>
          <td><input type="text" name="name" minlength="3" maxlength="24" pattern=".{3,24}" required placeholder="3 to 24 characters"></td>
        </tr>
        <tr>
          <td><label>email id</label></td>
          <td><input type="email" name="emailid" minlength="6" maxlength="64" pattern=".{6,64}" required placeholder="real emailid"></td>
        </tr>
        <tr>
          <td><label>Password</label></td>
          <td><input type="password" name="password" minlength="6" maxlength="12" pattern=".{6,12}" required placeholder="6 to 12 characters"></td></tr>
        </tr>
        <tr>
          <td><label>Confirm Password</label></td>
          <td><input type="password" name="confirmpassword" minlength="6" maxlength="12" pattern=".{6,12}" required placeholder="re-enter your password"></td></tr>
        </tr>
        <tr>
          <td><label>Preferred Cuisines</label></td>
          <td>
            <div class="searchfield searchcuisines">
              <label><input type="checkbox" name="cuisines[southindian]">South Indian</label>
              <br>
              <label><input type="checkbox" name="cuisines[northindian]">North Indian</label>
              <br>
              <label><input type="checkbox" name="cuisines[american]">American</label>
              <br>
              <label><input type="checkbox" name="cuisines[barbecue]">Barbecue</label>
              <br>
              <label><input type="checkbox" name="cuisines[chinese]">Chinese</label>
              <br>
              <label><input type="checkbox" name="cuisines[italian]">Italian</label>
              <br>
              <label><input type="checkbox" name="cuisines[mexican]">Mexican</label>
              <br>
              <label><input type="checkbox" name="cuisines[desserts]">Desserts</label>
              <br>
            </div>            
          </td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit">Create</button></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
  var handlesignup = function(event){
    // event.preventDefault();
    var formelement = event.target;

    var password = formelement.querySelector('input[name=password]').value;
    var confirmpassword = formelement.querySelector('input[name=confirmpassword]').value;

    if(!(password.length>5) || !(password.length<13)){
      alert("Password must be 6 to 12 characters long");
      return false;
    }

    // console.log(password,confirmpassword);
    
    if(password!==confirmpassword){
      alert("Password and Confirm Password must match");
      return false;
    }
    return true;
  };
</script>
