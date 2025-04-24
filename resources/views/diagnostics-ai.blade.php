<x-layouts.app :title="__('DiagnosticsAI')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="p-6 h-full flex-1 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="flex flex-col gap-4 h-full">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">DiagnosticsAI Assistant</h2>
                    <div class="flex gap-2">
                        <button id="testApiBtn" class="text-sm px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-md hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                            Test API Connection
                        </button>
                        <button id="clearChat" class="text-sm px-3 py-1 bg-neutral-100 dark:bg-neutral-700 rounded-md hover:bg-neutral-200 dark:hover:bg-neutral-600 transition">
                            Clear Chat
                        </button>
                        <button id="saveChat" class="text-sm px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-md hover:bg-primary-200 dark:hover:bg-primary-800 transition">
                            Save Conversation
                        </button>
                    </div>
                </div>
                
                <div class="p-4 mb-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-blue-700 dark:text-blue-300 font-medium">Welcome to DiagnosticsAI for {{ $make }} {{ $model }}</p>
                            <p class="text-blue-600 dark:text-blue-400 text-sm mt-1">Describe any issues or symptoms you're experiencing with your vehicle, and I'll help diagnose the problem and suggest potential solutions.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Messages Container -->
                <div id="chatMessages" class="flex-1 overflow-y-auto border rounded-lg p-4 mb-4 space-y-4" style="min-height: 300px; max-height: 500px;">
                    <!-- AI Message -->
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.504 1.132a1 1 0 01.992 0l1.75 1a1 1 0 11-.992 1.736L10 3.152l-1.254.716a1 1 0 11-.992-1.736l1.75-1zM5.618 4.504a1 1 0 01-.372 1.364L5.016 6l.23.132a1 1 0 11-.992 1.736L4 7.723V8a1 1 0 01-2 0V6a.996.996 0 01.52-.878l1.734-.99a1 1 0 011.364.372zm8.764 0a1 1 0 011.364-.372l1.733.99A1.002 1.002 0 0118 6v2a1 1 0 11-2 0v-.277l-.254.145a1 1 0 11-.992-1.736l.23-.132-.23-.132a1 1 0 01-.372-1.364zm-7 4a1 1 0 011.364-.372L10 8.848l1.254-.716a1 1 0 11.992 1.736L11 10.58V12a1 1 0 11-2 0v-1.42l-1.246-.712a1 1 0 01-.372-1.364zM3 11a1 1 0 011 1v1.42l1.246.712a1 1 0 11-.992 1.736l-1.75-1A1 1 0 012 14v-2a1 1 0 011-1zm14 0a1 1 0 011 1v2a1 1 0 01-.504.868l-1.75 1a1 1 0 11-.992-1.736L16 13.42V12a1 1 0 011-1zm-9.618 5.504a1 1 0 011.364-.372l.254.146l.254-.146a1 1 0 11.992 1.736l-1.246.712a.997.997 0 01-1.3-.1l-.1-.1-1.246-.712a1 1 0 01-.372-1.364z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-neutral-700 rounded-lg p-3 shadow-sm max-w-3xl">
                            <p class="text-neutral-800 dark:text-neutral-200">Hello! I'm your DiagnosticsAI assistant for your {{ $make }} {{ $model }}. How can I help you today? Please describe any issues or symptoms you're experiencing with your vehicle.</p>
                        </div>
                    </div>
                    
                    <!-- Loading message template (hidden by default) -->
                    <div id="loadingMessage" class="flex items-start mb-4 hidden">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-neutral-700 rounded-lg p-3 shadow-sm max-w-3xl">
                            <p class="text-neutral-800 dark:text-neutral-200">Analyzing your issue...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Message Input -->
                <form id="diagnosticsForm" class="border rounded-lg p-3 flex items-end">
                    <input type="hidden" name="registration" value="{{ $registration }}">
                    <textarea 
                        id="messageInput"
                        name="message"
                        class="flex-1 p-2 bg-transparent border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                        placeholder="Describe the issue with your vehicle..."
                        rows="3"
                    ></textarea>
                    <button 
                        id="sendButton"
                        type="submit" 
                        class="ml-3 p-2 bg-primary-500 hover:bg-primary-600 rounded-full flex items-center justify-center text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
                
                <div class="text-center text-sm text-neutral-500 dark:text-neutral-400">
                    <p>DiagnosticsAI provides suggestions based on common symptoms. For critical issues, please consult a professional mechanic.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const diagnosticsForm = document.getElementById('diagnosticsForm');
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.getElementById('sendButton');
            const chatMessages = document.getElementById('chatMessages');
            const loadingMessage = document.getElementById('loadingMessage');
            const clearChatButton = document.getElementById('clearChat');
            const saveChatButton = document.getElementById('saveChat');
            
            // Handle Enter key press
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (messageInput.value.trim() !== '') {
                        diagnosticsForm.dispatchEvent(new Event('submit'));
                    }
                }
            });
            
            // Handle form submission
            diagnosticsForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                if (message === '') return;
                
                // Add user message to chat
                addUserMessage(message);
                
                // Clear input
                messageInput.value = '';
                
                // Show loading indicator
                loadingMessage.classList.remove('hidden');
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Send request to server
                const formData = new FormData(diagnosticsForm);
                const registration = formData.get('registration');
                
                console.log('Sending message to API:', message);
                console.log('Vehicle Registration:', registration);
                
                fetch(`/vehicle/${registration}/diagnostics/process`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: message,
                        registration: registration
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    // Hide loading indicator
                    loadingMessage.classList.add('hidden');
                    
                    console.log('API response data:', data);
                    
                    // Add AI response to chat
                    if (data.success) {
                        addAIMessage(data.message);
                    } else {
                        console.error('Error from API:', data.error || 'Unknown error');
                        addAIMessage("I'm sorry, I couldn't process your request. Please try again.");
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    loadingMessage.classList.add('hidden');
                    addAIMessage("I'm sorry, there was an error processing your request. Please try again.");
                });
            });
            
            // Add user message to chat
            function addUserMessage(message) {
                const messageElement = document.createElement('div');
                messageElement.className = 'flex items-start justify-end mb-4';
                messageElement.innerHTML = `
                    <div class="bg-primary-50 dark:bg-primary-900/30 rounded-lg p-3 shadow-sm max-w-3xl ml-auto">
                        <p class="text-neutral-800 dark:text-neutral-200">${escapeHtml(message)}</p>
                    </div>
                    <div class="flex-shrink-0 ml-3">
                        <div class="w-8 h-8 rounded-full bg-neutral-300 dark:bg-neutral-600 flex items-center justify-center text-neutral-700 dark:text-neutral-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            
            // Add AI message to chat
            function addAIMessage(message) {
                const messageElement = document.createElement('div');
                messageElement.className = 'flex items-start mb-4';
                
                // Process message text (handling line breaks)
                const formattedMessage = message.replace(/\n\n/g, '</p><p class="mt-2 text-neutral-800 dark:text-neutral-200">').replace(/\n/g, '<br>');
                
                messageElement.innerHTML = `
                    <div class="flex-shrink-0 mr-3">
                        <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.504 1.132a1 1 0 01.992 0l1.75 1a1 1 0 11-.992 1.736L10 3.152l-1.254.716a1 1 0 11-.992-1.736l1.75-1zM5.618 4.504a1 1 0 01-.372 1.364L5.016 6l.23.132a1 1 0 11-.992 1.736L4 7.723V8a1 1 0 01-2 0V6a.996.996 0 01.52-.878l1.734-.99a1 1 0 011.364.372zm8.764 0a1 1 0 011.364-.372l1.733.99A1.002 1.002 0 0118 6v2a1 1 0 11-2 0v-.277l-.254.145a1 1 0 11-.992-1.736l.23-.132-.23-.132a1 1 0 01-.372-1.364zm-7 4a1 1 0 011.364-.372L10 8.848l1.254-.716a1 1 0 11.992 1.736L11 10.58V12a1 1 0 11-2 0v-1.42l-1.246-.712a1 1 0 01-.372-1.364zM3 11a1 1 0 011 1v1.42l1.246.712a1 1 0 11-.992 1.736l-1.75-1A1 1 0 012 14v-2a1 1 0 011-1zm14 0a1 1 0 011 1v2a1 1 0 01-.504.868l-1.75 1a1 1 0 11-.992-1.736L16 13.42V12a1 1 0 011-1zm-9.618 5.504a1 1 0 011.364-.372l.254.146l.254-.146a1 1 0 11.992 1.736l-1.246.712a.997.997 0 01-1.3-.1l-.1-.1-1.246-.712a1 1 0 01-.372-1.364z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-neutral-700 rounded-lg p-3 shadow-sm max-w-3xl">
                        <p class="text-neutral-800 dark:text-neutral-200">${formattedMessage}</p>
                    </div>
                `;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            
            // Helper function to escape HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Clear chat history
            clearChatButton.addEventListener('click', function() {
                // Keep only the first welcome message
                const welcomeMessage = chatMessages.firstElementChild;
                chatMessages.innerHTML = '';
                chatMessages.appendChild(welcomeMessage);
            });
            
            // Save chat history
            saveChatButton.addEventListener('click', function() {
                const messages = chatMessages.querySelectorAll('.flex.items-start');
                let chatText = '# DiagnosticsAI Chat History - ' + new Date().toLocaleString() + '\n\n';
                
                messages.forEach(message => {
                    if (message.classList.contains('justify-end')) {
                        // User message
                        chatText += '**You**: ' + message.querySelector('p').textContent + '\n\n';
                    } else if (!message.id || message.id !== 'loadingMessage') {
                        // AI message
                        chatText += '**DiagnosticsAI**: ' + message.querySelector('p').textContent + '\n\n';
                    }
                });
                
                // Create a blob and download link
                const blob = new Blob([chatText], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'diagnostics-chat-' + new Date().toISOString().slice(0, 10) + '.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });

            // Test API connection button
            const testApiBtn = document.getElementById('testApiBtn');
            testApiBtn.addEventListener('click', function() {
                testApiBtn.textContent = 'Testing...';
                testApiBtn.disabled = true;
                
                console.log('Testing OpenAI API connection...');
                
                fetch('/diagnostics/test-api')
                    .then(response => {
                        console.log('API test response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('API test results:', data);
                        
                        let message;
                        if (data.connection_status === 'success') {
                            message = `✅ API Connection Success!\nModel: ${data.model}\nResponse: "${data.test_response}"`;
                        } else if (data.connection_status === 'no_key') {
                            message = '⚠️ No API key configured. Please add your OpenAI API key in the settings.';
                        } else {
                            message = `❌ API Connection Failed: ${data.error || 'Unknown error'}`;
                        }
                        
                        // Show results in a temporary message
                        const resultDiv = document.createElement('div');
                        resultDiv.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg max-w-md';
                        
                        if (data.connection_status === 'success') {
                            resultDiv.classList.add('bg-green-50', 'dark:bg-green-900/30', 'border', 'border-green-200', 'dark:border-green-800');
                        } else if (data.connection_status === 'no_key') {
                            resultDiv.classList.add('bg-yellow-50', 'dark:bg-yellow-900/30', 'border', 'border-yellow-200', 'dark:border-yellow-800');
                        } else {
                            resultDiv.classList.add('bg-red-50', 'dark:bg-red-900/30', 'border', 'border-red-200', 'dark:border-red-800');
                        }
                        
                        resultDiv.innerHTML = `
                            <div class="flex justify-between items-start">
                                <div class="flex-1 mr-4">
                                    <p class="whitespace-pre-wrap text-sm">${message}</p>
                                </div>
                                <button class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        `;
                        
                        document.body.appendChild(resultDiv);
                        
                        resultDiv.querySelector('button').addEventListener('click', function() {
                            resultDiv.remove();
                        });
                        
                        setTimeout(() => {
                            if (document.body.contains(resultDiv)) {
                                resultDiv.remove();
                            }
                        }, 10000);
                        
                        testApiBtn.textContent = 'Test API Connection';
                        testApiBtn.disabled = false;
                    })
                    .catch(error => {
                        console.error('API test error:', error);
                        testApiBtn.textContent = 'Test API Connection';
                        testApiBtn.disabled = false;
                        
                        alert('Error testing API connection: ' + error.message);
                    });
            });
        });
    </script>
</x-layouts.app> 