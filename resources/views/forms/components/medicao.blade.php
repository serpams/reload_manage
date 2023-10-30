<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <!DOCTYPE html>
        <html>

        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;

                }

                th,
                td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                .toggle {
                    cursor: pointer;
                    user-select: none;
                    padding-left: 10px;
                }

                .green-bg {
                    background-color: lightgreen;
                }

                /* Estilos CSS existentes aqui... */
                .highlight {
                    background-color: pink;
                }

                .loader {
                    border: 16px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 16px solid #3498db;
                    width: 120px;
                    height: 120px;
                    -webkit-animation: spin 2s linear infinite;
                    /* Safari */
                    animation: spin 2s linear infinite;
                }

                /* Safari */
                @-webkit-keyframes spin {
                    0% {
                        -webkit-transform: rotate(0deg);
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                    }
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }

                #tree-table-container {
                    height: 600px;
                    overflow-y: scroll;
                }
            </style>
        </head>


        <body>
            <div>

            </div>

            <input type="text" id="searchInput" placeholder="Pesquisar por Item ou Serviço">
            <button onclick="searchItem()">Buscar</button>
            <input type="text" id="searchServiceInput" placeholder="Pesquisar por Serviço">
            <button onclick="searchService()">Buscar por Serviço</button>
            <div id="tree-table-container">
                <div style="text-align:center ;justify-content:center; margin-left:45%">
                    <div id="loading" class="loader "></div>
                </div>
                <table id="repaer">
                    <thead>
                        <tr>
                            <th>Item</th>
                        </tr>
                    </thead>
                    <tbody id="tree-table">
                    </tbody>
                </table>
            </div>

        </body>


        <script>
            let items = [];
            // fetch api /api/getorcamento/{obra_id}
            async function getOrcamento() {
                // resolve
                console.log('fech_one')
                //
                const response = await fetch('/getorcamento/' + {{ $tenant_id }});
                const data = await response.json();
                let itens = data.map((item, index) => {
                    return {
                        index: index,
                        item: item.item,
                        servico: item.servico,
                        percentual: item.percentual
                    }
                })
                items = itens;

                //resolve promisse
                setTimeout(() => {
                    //l et it be
                    const tree = buildTree(itens);
                    const treeTable = document.getElementById('tree-table');
                    buildCollapsibleTable(tree, treeTable, [], false, itens); //
                }, 1000);

                // remove loading

                return data;
            }
            async function runanother() {

            }
            getOrcamento();
            let indexOfInputs = [];

            // Função para construir a tabela HTML colapsável de forma recursiva com três colunas (Item, Serviço e Percentual)
            function buildCollapsibleTable(tree, parentTable, path = [], isCollapsed = true) {
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                // Crie a linha de cabeçalho com três colunas
                const headerRow = document.createElement('tr');
                const headerItem = document.createElement('th');
                headerItem.textContent = 'Item';
                const headerServico = document.createElement('th');
                headerServico.textContent = 'Serviço';
                const headerPercentual = document.createElement('th');
                headerPercentual.textContent = 'Percentual';

                headerRow.appendChild(headerItem);
                headerRow.appendChild(headerServico);
                headerRow.appendChild(headerPercentual);
                thead.appendChild(headerRow);
                table.appendChild(thead);

                for (const key in tree) {
                    const row = document.createElement('tr');
                    const cellItem = document.createElement('td');
                    const cellServico = document.createElement('td');
                    const cellPercentual = document.createElement('td');
                    const cellInput = document.createElement('td');
                    const input = document.createElement('input');
                    input.setAttribute('type', 'text');


                    const toggle = document.createElement('span');

                    toggle.classList.add('toggle');
                    if (Object.keys(tree[key]).length > 0) {
                        toggle.textContent = isCollapsed ? '►' : '▼';
                    }
                    cellItem.appendChild(toggle);
                    const fullPath = [...path, key].join('.');
                    cellItem.appendChild(document.createTextNode(fullPath));
                    input.setAttribute('id', fullPath);
                    // add function on key 'enter' press go next input where is in indexofinputs
                    input.addEventListener('keyup', function(e) {
                        if (e.keyCode === 13) {
                            let index = indexOfInputs.indexOf(fullPath);
                            if (index < indexOfInputs.length - 1) {
                                document.getElementById(indexOfInputs[index + 1]).focus();
                            }
                        }
                        // if key 'up' press go previous input where is in indexofinputs
                        if (e.keyCode === 38) {
                            let index = indexOfInputs.indexOf(fullPath);
                            if (index > 0) {
                                document.getElementById(indexOfInputs[index - 1]).focus();
                            }
                        }
                        // if key 'down' press go next input where is in indexofinputs
                        if (e.keyCode === 40) {
                            let index = indexOfInputs.indexOf(fullPath);
                            if (index < indexOfInputs.length - 1) {
                                document.getElementById(indexOfInputs[index + 1]).focus();
                            }
                        }
                    })
                    cellInput.appendChild(input);

                    let indexArray = items.findIndex(item => item.item === fullPath)
                    console.log(indexArray)
                    try {
                        cellServico.textContent = items[indexArray].servico || ''; // Adiciona o valor do serviço
                        cellPercentual.textContent = items[indexArray].percentual || ''; // Adiciona o valor do percentual
                    } catch (error) {
                        cellServico.textContent = ''; // Adiciona o valor do serviço
                        cellPercentual.textContent = ''; // Adiciona o valor do percentual
                    }


                    row.appendChild(cellItem);
                    row.appendChild(cellServico);
                    row.appendChild(cellPercentual);

                    tbody.appendChild(row);

                    const subTree = tree[key];
                    if (Object.keys(subTree).length > 0) {
                        const subTable = buildCollapsibleTable(subTree, table, [...path, key], isCollapsed);
                        subTable.style.display = isCollapsed ? 'none' : 'table';
                        toggle.textContent = isCollapsed ? '►' : '▼';

                        toggle.addEventListener('click', () => {
                            if (subTable.style.display === 'none') {
                                subTable.style.display = 'table';
                                toggle.textContent = '▼';
                            } else {
                                subTable.style.display = 'none';
                                toggle.textContent = '►';
                            }
                        });

                        // Criar uma nova linha para cada filho
                        const newRow = document.createElement('tr');
                        // essa linha de filho devera ter o  colspan do pai


                        const newCell = document.createElement('td');
                        newCell.setAttribute('colspan', '3');
                        newCell.appendChild(subTable);
                        newRow.appendChild(newCell);
                        tbody.appendChild(newRow);
                    } else {
                        // Se não tiver filhos, definir o fundo verde claro
                        indexOfInputs.push(fullPath);
                        row.appendChild(cellInput);
                        row.classList.add('green-bg');
                    }
                }

                table.appendChild(tbody);
                parentTable.appendChild(table);

                try {
                    setTimeout(() => {
                        document.getElementById('loading').remove();
                        // tree-table-container  create a virtual scroll to this div limit height to 600 and overflow-y:scroll
                        ;




                    }, 3000);
                } catch (error) {

                }
                return table;
            }
            // Função para buscar itens na árvore

            function buildTree(items) {
                const tree = {};

                for (const item of items) {
                    const parts = item.item.split('.');
                    let currentNode = tree;

                    for (const part of parts) {
                        if (!currentNode[part]) {
                            currentNode[part] = {};
                        }
                        currentNode = currentNode[part];
                    }
                }

                return tree;
            }


            function searchItem() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const treeTable = document.getElementById('tree-table');

                // Remova destaques anteriores
                const highlightedItems = document.querySelectorAll('.highlight');
                highlightedItems.forEach(item => {
                    item.classList.remove('highlight');
                });

                // Realize a pesquisa em todos os itens
                const allItems = treeTable.querySelectorAll('td:first-child');
                let found = false;

                allItems.forEach(item => {
                    const itemText = item.textContent.toLowerCase();
                    if (itemText.includes(searchTerm)) {
                        // Encontrei um item correspondente, destaque-o e role até ele
                        item.classList.add('highlight');
                        item.scrollIntoView({
                            behavior: 'smooth'
                        });
                        found = true;
                    }
                });

                if (!found) {
                    // Item não encontrado, exiba uma mensagem ou realize outra ação apropriada
                    alert('Item não encontrado.');
                }
            }

            function searchService() {
                //prevent submint
                event.preventDefault();

                const searchServiceTerm = document.getElementById('searchServiceInput').value.toLowerCase();
                const treeTable = document.getElementById('tree-table');

                // Remova destaques anteriores
                const highlightedItems = document.querySelectorAll('.highlight');
                highlightedItems.forEach(item => {
                    item.classList.remove('highlight');
                });

                // Realize a pesquisa em todos os serviços
                const allServices = treeTable.querySelectorAll('td:nth-child(2)');
                let found = false;

                allServices.forEach(service => {
                    const serviceText = service.textContent.toLowerCase();
                    if (serviceText.includes(searchServiceTerm)) {
                        // Encontrei um serviço correspondente, destaque-o e role até ele
                        service.closest('tr').querySelector('td:first-child').classList.add('highlight');
                        service.scrollIntoView({
                            behavior: 'smooth'
                        });


                        found = true;
                    }
                });

                if (!found) {
                    // Serviço não encontrado, exiba uma mensagem ou realize outra ação apropriada
                    alert('Serviço não encontrado.');
                }
            }
        </script>

        </html>

    </div>
</x-dynamic-component>
