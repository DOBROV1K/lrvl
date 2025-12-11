<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            OAuth2 API токены
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Используйте эти токены для доступа к API приложения. Храните их в безопасности.
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <form method="POST" action="{{ route('profile.tokens.create') }}" class="space-y-4">
            @csrf
            
            <div>
                <x-input-label for="token_name" value="Название токена" />
                <x-text-input id="token_name" name="token_name" type="text" class="mt-1 block w-full" 
                    placeholder="Например: Mobile App" required />
                <x-input-error class="mt-2" :messages="$errors->get('token_name')" />
            </div>

            <x-primary-button>
                Создать токен
            </x-primary-button>
        </form>

        @if(session('token'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                <h3 class="text-sm font-medium text-green-800 mb-2">
                    Токен успешно создан!
                </h3>
                <p class="text-sm text-green-700 mb-2">
                    Скопируйте этот токен сейчас. Вы не сможете увидеть его снова!
                </p>
                <div class="flex items-center gap-2">
                    <code class="flex-1 p-2 bg-white border border-green-300 rounded text-sm break-all" id="new-token">
                        {{ session('token') }}
                    </code>
                    <button type="button" onclick="copyToken()" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Копировать
                    </button>
                </div>
            </div>
        @endif


        @if($tokens->count() > 0)
            <div>
                <h3 class="text-md font-medium text-gray-900 mb-3">Активные токены</h3>
                
                <div class="space-y-2">
                    @foreach($tokens as $token)
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded">
                            <div>
                                <p class="font-medium text-gray-900">{{ $token->name }}</p>
                                <p class="text-sm text-gray-600">
                                    Создан: {{ $token->created_at->format('d.m.Y H:i') }}
                                </p>
                            </div>
                            
                            <form method="POST" action="{{ route('profile.tokens.destroy', $token->id) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button onclick="return confirm('Удалить этот токен?')">
                                    Удалить
                                </x-danger-button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-sm text-gray-600">У вас пока нет активных токенов.</p>
        @endif

        <div class="p-4 bg-blue-50 border border-blue-200 rounded-md">
            <h3 class="text-sm font-medium text-blue-800 mb-2">
                Как использовать API
            </h3>
            <div class="text-sm text-blue-700 space-y-2">
                <p><strong>Base URL:</strong> <code>{{ url('/api') }}</code></p>
                <p><strong>Аутентификация:</strong> Добавьте заголовок</p>
                <code class="block p-2 bg-white border border-blue-300 rounded">
                    Authorization: Bearer ВАШ_ТОКЕН
                </code>
                <p class="mt-2"><strong>Доступные эндпоинты:</strong></p>
                <ul class="list-disc list-inside space-y-1">
                    <li>GET /api/clubs - список клубов</li>
                    <li>GET /api/clubs/{id} - информация о клубе</li>
                    <li>POST /api/clubs - создать клуб</li>
                    <li>PUT /api/clubs/{id} - обновить клуб</li>
                    <li>DELETE /api/clubs/{id} - удалить клуб</li>
                    <li>GET /api/players - список игроков</li>
                    <li>POST /api/players - создать игрока</li>
                    <li>PUT /api/players/{id} - обновить игрока</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function copyToken() {
            const tokenText = document.getElementById('new-token').textContent.trim();
            navigator.clipboard.writeText(tokenText).then(() => {
                alert('Токен скопирован в буфер обмена!');
            });
        }
    </script>
</section>