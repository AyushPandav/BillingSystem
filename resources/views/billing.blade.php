<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 16px;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 24px;
            width: 100%;
            max-width: 900px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 24px;
        }

        .nav-link {
            display: block;
            text-align: right;
            margin-bottom: 16px;
        }

        .nav-link a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .nav-link a:hover {
            text-decoration: underline;
        }

        .form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }

        .form button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form button:hover {
            background-color: #0056b3;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        td {
            color: #555;
        }

        .remove-btn {
            color: #dc3545;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .remove-btn:hover {
            color: #a71d2a;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-bottom: 16px;
        }

        .save-btn {
            display: block;
            margin-left: auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .save-btn:hover {
            background-color: #1e7e34;
        }

        @media (max-width: 600px) {
            .form {
                grid-template-columns: 1fr;
            }

            .table-container {
                max-height: 300px;
            }

            th, td {
                font-size: 14px;
                padding: 8px;
            }

            h1 {
                font-size: 24px;
            }

            .total {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-link">
            <a href="{{ route('billing.history') }}">View Bills History</a>
        </div>
        <h1>Billing System</h1>

        <form id="billingForm" class="form">
            <input type="text" id="itemName" placeholder="Item Name" required>
            <input type="number" id="itemQuantity" placeholder="Quantity" min="1" required>
            <input type="number" id="itemPrice" placeholder="Price" min="0" step="0.01" required>
            <button type="submit">Add Item</button>
        </form>

        <div class="table-container">
            <table id="itemsTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    <tr id="noItems">
                        <td colspan="5" style="text-align: center; color: #777;">No items added</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total">
            Total: $<span id="totalAmount">0.00</span>
        </div>

        <button class="save-btn" id="saveBill">Save Bill</button>
    </div>

    <script>
        const items = [];
        const form = document.getElementById('billingForm');
        const itemsBody = document.getElementById('itemsBody');
        const totalAmount = document.getElementById('totalAmount');
        const noItemsRow = document.getElementById('noItems');
        const saveBillBtn = document.getElementById('saveBill');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('itemName').value;
            const quantity = parseInt(document.getElementById('itemQuantity').value);
            const price = parseFloat(document.getElementById('itemPrice').value);

            if (name && quantity > 0 && price >= 0) {
                items.push({ name, quantity, price });
                updateTable();
                form.reset();
            }
        });

        function updateTable() {
            itemsBody.innerHTML = '';
            if (items.length === 0) {
                itemsBody.appendChild(noItemsRow);
            } else {
                noItemsRow.remove();
                items.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>$${(item.quantity * item.price).toFixed(2)}</td>
                        <td><button class="remove-btn" data-index="${index}">Remove</button></td>
                    `;
                    itemsBody.appendChild(row);
                });
            }
            updateTotal();
        }

        function updateTotal() {
            const total = items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            totalAmount.textContent = total.toFixed(2);
        }

        itemsBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-btn')) {
                const index = e.target.dataset.index;
                items.splice(index, 1);
                updateTable();
            }
        });

        saveBillBtn.addEventListener('click', () => {
            if (items.length === 0) {
                alert('No items to save!');
                return;
            }
            fetch('/billing/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    items,
                    total: parseFloat(totalAmount.textContent)
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Bill saved successfully!');
                items.length = 0;
                updateTable();
                window.location.href = '/bills'; // Redirect to history page
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save bill.');
            });
        });
    </script>
</body>
</html>
