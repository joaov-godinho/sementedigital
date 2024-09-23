<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Calendário de Tarefas") }}
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: '/tarefas/eventos',
                select: function(info) {
                    var title = prompt('Título da tarefa:');
                    if (title) {
                        var start = info.startStr;
                        var end = info.endStr;
                        fetch('/tarefas/salvar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({
                                title: title,
                                start: start,
                                end: end
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                calendar.addEvent({
                                    id: data.id,
                                    title: title,
                                    start: start,
                                    end: end,
                                });
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                    }
                    calendar.unselect();
                },
                eventClick: function(info) {
                    const existingButtons = info.el.querySelectorAll('.edit-button, .delete-button');
                    existingButtons.forEach(button => button.remove());

                    var editButton = document.createElement('button');
                    editButton.innerText = 'Editar';
                    editButton.classList.add('edit-button');
                    editButton.style.marginRight = '5px'; // Espaço à direita
                    editButton.style.backgroundColor = '#4CAF50'; // Verde
                    editButton.style.color = 'white';
                    editButton.style.border = 'none';
                    editButton.style.padding = '5px 10px';
                    editButton.style.cursor = 'pointer';
                    editButton.onclick = function() {
                        var newTitle = prompt("Editar título da tarefa:", info.event.title);
                        if (newTitle !== null) {
                            info.event.setProp('title', newTitle);
                            updateEvent(info.event);
                        }
                    };

                    var deleteButton = document.createElement('button');
                    deleteButton.innerText = 'Excluir';
                    deleteButton.classList.add('delete-button');
                    deleteButton.style.backgroundColor = '#f44336'; // Vermelho
                    deleteButton.style.color = 'white';
                    deleteButton.style.border = 'none';
                    deleteButton.style.padding = '5px 10px';
                    deleteButton.style.cursor = 'pointer';
                    deleteButton.onclick = function() {
                        if (confirm("Deseja remover este evento?")) {
                            fetch(`/tarefas/excluir/${info.event.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'Tarefa excluída com sucesso!') {
                                    info.event.remove();
                                } else {
                                    alert(data.status);
                                }
                            })
                            .catch(error => console.error('Erro:', error));
                        }
                    };

                    var eventElement = info.el;
                    eventElement.appendChild(editButton);
                    eventElement.appendChild(deleteButton);
                },
                eventDrop: function(info) {
                    updateEvent(info.event);
                }
            });

            calendar.render();
        });

        function updateEvent(event) {
            fetch(`/tarefas/atualizar/${event.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    title: event.title,
                    start: event.start.toISOString().slice(0, 19).replace('T', ' '),
                    end: event.end ? event.end.toISOString().slice(0, 19).replace('T', ' ') : null
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.status) {
                    alert(data.message || 'Erro ao atualizar a tarefa.');
                }
            })
            .catch(error => console.error('Erro:', error));
        }
    </script>
</x-app-layout>
