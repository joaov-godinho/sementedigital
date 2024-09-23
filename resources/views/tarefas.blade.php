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

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: '/tarefas/eventos', // Carrega os eventos do backend
                select: function(info) {
                    var title = prompt('Título da tarefa:');
                    if (title) {
                        var start = info.startStr;
                        var end = info.endStr;

                        // Enviar os dados para o back-end
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
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status) {
                                // Adiciona o evento ao calendário com os valores corretos
                                calendar.addEvent({
                                    id: data.id,       // ID retornado pelo backend
                                    title: title,      // Título que foi inserido no prompt
                                    start: start,      // Data de início selecionada
                                    end: end,          // Data de fim selecionada
                                });
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                    }
                    calendar.unselect(); // Desseleciona o intervalo de datas após o evento ser criado
                },
                eventClick: function(info) {
                    if (confirm("Deseja remover este evento?")) {
                        // Enviar pedido de exclusão para o backend
                        fetch(`/tarefas/excluir/${info.event.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(response => response.json()) // Converta a resposta para JSON
                        .then(data => {
                            if (data.status === 'Tarefa excluída com sucesso!') {
                                // Remove o evento do calendário
                                info.event.remove();
                            } else {
                                alert(data.status); // Exibe a mensagem de erro
                            }
                        })
                        .catch(error => console.error('Erro:', error));
                    }
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>
