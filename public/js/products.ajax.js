/*
 * products.ajax.js
 */

function sumColumn(table, columnIndex) {

    let sum = 0;
    const formatter = new Intl.NumberFormat('en-US');
  
    for (let i = 0; i < table.rows.length-1; i++) {
      const row = table.rows[i];
      if (row.cells.length > columnIndex) {
        const cellValue = parseFloat(row.cells[columnIndex].textContent.replace(/,/g, ''));
        if (!isNaN(cellValue)) {
          sum += cellValue;
        }
      }
    }
    return formatter.format(sum.toFixed(2));
}

function updateTable(newData) {

    const formatter = new Intl.NumberFormat('en-US');

    const table = document.getElementById('productTable');
    const newRow = table.insertRow(table.rows.length - 1); 
    
    const nameCell = newRow.insertCell(0);
    nameCell.textContent = newData.name;

    const quantityCell = newRow.insertCell(1);
    quantityCell.textContent = newData.quantity;

    const priceCell = newRow.insertCell(2);
    priceCell.textContent = formatter.format(parseFloat(newData.price).toFixed(2));

    const createdAtCell = newRow.insertCell(3);
    createdAtCell.textContent = newData.created_at.slice(0,19).replace('T', ' ');

    const totalValueCell = newRow.insertCell(4);
    totalValueCell.textContent = parseFloat(newData.price * newData.quantity).toFixed(2);

    const totalValuesField = document.getElementById('totalValues');
    if (totalValuesField) {
        totalValuesField.textContent = sumColumn(table, 4);
    }
}

function getClosestElementWithClass(element, className) {    
    if (element && element.classList && element.classList.contains(className)) {
        return element; 
    }
    for (let child of element.children) {
        const found = child.classList.contains(className);
        if (found) {     
            return child; 
        }
    }    
    // Recursively check parent nodes
    return element.parentElement ? getClosestElementWithClass(element.parentElement, className) : null;
}

function showValidationMessages(form, messages = {}) {
    // Loop through each input field
    console.log(messages);
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        console.log(input.name);
        if (!input.validity.valid || messages.hasOwnProperty(input.name)) {
            // Show the invalid-feedback with a custom message            
            const feedback = getClosestElementWithClass(input, 'invalid-feedback');
            if (feedback) {
                if (messages.hasOwnProperty(input.name)) {
                    feedback.textContent = messages[input.name];
                } else if (input.validity.valueMissing) {
                    feedback.textContent = 'This field is required.';
                } else {
                    feedback.textContent = `Please provide a valid ${input.name}.`;
                }      
                feedback.style.display = 'block';
                setTimeout(() => {
                    feedback.style.display = 'none';
                }, 3000);
                input.classList.add('is-invalid'); // Bootstrap styling
            }
        } else {
            input.classList.remove('is-invalid');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {    
    const form = document.getElementById('productForm');
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent form submission
        event.stopPropagation();
        if (!form.checkValidity()) {  
            showValidationMessages(form);                                  
            return false;
        }          
        form.classList.add('was-validated');
        const formData = new FormData(form);
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Important! so that you get back json
            'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content
        }        
        console.log(headers);
        // submit data
        fetch('/products', {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(Object.fromEntries(formData.entries()))
        })
        .then(async response => {
            if (!response.ok) {
                const errorData = await response.json();
                throw errorData; // Throwing here ensures it lands in the catch block
            }
            return response.json();        
        })
        .then(data => {            
            // Handle the response data 
            form.reset();
            form.classList.remove('was-validated');
            updateTable(data);
        })
        .catch(error => {
            // Handle errors
            console.error(error);
            form.classList.remove('was-validated');
            showValidationMessages(form, error.errors);
            // console.error('Error:', error);
        });
    });
});

