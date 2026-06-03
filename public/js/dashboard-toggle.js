const togglemcs = document.getElementById('switch-mcs');
const multiselect = document.getElementById('advanced-form');

togglemcs.addEventListener('change', function() {
    if(this.checked) {
        multiselect.classList.remove('hide');
    } else{
        multiselect.classList.add('hide');
    }
})

const toggleExport = document.getElementById('switch-export');
const exportCont = document.getElementById('export-container');

toggleExport.addEventListener('change', function() {
    if(this.checked) {
        exportCont.classList.remove('hide');
    } else{
        exportCont.classList.add('hide');
    }
})