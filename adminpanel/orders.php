    
<div class="main-container">
      <h2 class="admin_h2">Beställningar</h2>
      <p class="filtrera-p">Filtrera beställningar</p>
          <form class="search-form" action="" method="post">
        <input class="search-input" type="text" />
        <button class="search-submit-btn" type="submit">Sök</button>
    </form>

  
    <div class="radio-div">
    <input type="radio" id="alla" name="alla" checked="checked">
    <label for="alla">Alla beställningar</label>
    <input type="radio" id="aktiva" name="alla">
    <label for="aktiva">Aktiva beställningar</label>
    <input type="radio" id="slutförda" name="alla">
    <label for="slutförda">Slutförda beställningar</label>
    </div>

  <div class="selectbox-div">
  <select id="sort">
  <option value="senaste">Senaste beställningarna</option>
  <option value="tidgaste">Äldsta beställningarna</option>
  <option value="dyraste">Dyraste beställningarna</option>
  <option value="billigaste">Billigaste beställningarna</option>
  <option value="Obehandlade">Obehandlade beställningar</option>
  <option value="behandlas">Behandlade beställningarna</option>
</select>
  </div>

</div>
