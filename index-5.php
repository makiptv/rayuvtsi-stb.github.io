<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RAYUVTSI-TV</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



    <style>

        /* Neomorphic Theme */

        body {

            background: #e0e0e0;

            color: #333;

            transition: background 0.3s, color 0.3s;

        }

        body.dark-mode {

            background: #121212;

            color: white;

        }



        /* Header */

        header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 15px;

            background: #e0e0e0;

            border-radius: 10px;

            box-shadow: 5px 5px 10px #b8b8b8, -5px -5px 10px #ffffff;

        }

        body.dark-mode header {

            background: #1f1f1f;

            box-shadow: 5px 5px 10px #0d0d0d, -5px -5px 10px #292929;

        }



        /* Centered Search Box */

        .search-container {

            display: flex;

            flex-grow: 1;

            justify-content: center;

            gap: 10px;

            align-items: center;

        }



        .search-box {

            padding: 8px 12px;

            border-radius: 20px;

            border: none;

            outline: none;

            background: #e0e0e0;

            box-shadow: inset 4px 4px 6px #b8b8b8, inset -4px -4px 6px #ffffff;

            width: 250px;

            text-align: center;

        }

        body.dark-mode .search-box {

            background: #1f1f1f;

            box-shadow: inset 4px 4px 6px #0d0d0d, inset -4px -4px 6px #292929;

            color: white;

        }



        /* Toggle Button */

        .toggle-label {

            width: 50px;

            height: 24px;

            background: #ccc;

            border-radius: 12px;

            display: flex;

            align-items: center;

            padding: 2px;

            cursor: pointer;

            transition: background 0.3s;

        }

        .toggle-ball {

            width: 20px;

            height: 20px;

            background: white;

            border-radius: 50%;

            transition: transform 0.3s;

        }

        body.dark-mode .toggle-label {

            background: #444;

        }

        body.dark-mode .toggle-ball {

            transform: translateX(26px);

        }



        /* Channel Grid */

        .channel {

            width: 100%;

            max-width: 250px;

            padding: 15px;

            border-radius: 15px;

            background: #e0e0e0;

            box-shadow: 8px 8px 12px #b8b8b8, -8px -8px 12px #ffffff;

            transition: 0.3s;

            position: relative;

            text-align: center;

        }

        .channel:hover {

            transform: scale(1.05);

        }

        body.dark-mode .channel {

            background: #1f1f1f;

            box-shadow: 8px 8px 12px #0d0d0d, -8px -8px 12px #292929;

        }



        /* Favorite Button */

        .favorite-icon {

            position: absolute;

            top: 10px;

            right: 10px;

            cursor: pointer;

            font-size: 20px;

            color: gray;

        }

        .favorite-icon.active {

            color: red;

        }



        /* Grid */

        .channel-grid {

            display: grid;

            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));

            gap: 20px;

            padding: 20px;

        }



        /* Logo */

        .logo {

            width: 50px;

            border-radius: 10px;

            box-shadow: 2px 2px 4px #bebebe, -2px -2px 4px #ffffff;

        }

    </style>



    <script>

        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        let allChannels = [];



        function toggleFavorite(event, channelName) {

            event.preventDefault();

            if (favorites.includes(channelName)) {

                favorites = favorites.filter(fav => fav !== channelName);

            } else {

                favorites.push(channelName);

            }

            localStorage.setItem('favorites', JSON.stringify(favorites));

            displayChannels(allChannels);

        }



        function fetchChannels() {

            fetch('ott-3.json')

                .then(response => response.json())

                .then(data => {

                    allChannels = data;

                    displayChannels(allChannels);

                })

                .catch(error => console.error('Error fetching channels:', error));

        }



        function displayChannels(channels, searchTerm = "") {

            const favoriteContainer = document.getElementById('favoriteChannels');

            const allContainer = document.getElementById('allChannels');



            // Clear existing channels to prevent duplicates

            favoriteContainer.innerHTML = '';

            allContainer.innerHTML = '';



            let filteredChannels = channels.filter(channel => 

                channel.name.toLowerCase().includes(searchTerm.toLowerCase())

            );



            const favoriteChannels = filteredChannels.filter(channel => favorites.includes(channel.name));

            const otherChannels = filteredChannels.filter(channel => !favorites.includes(channel.name));



            if (favoriteChannels.length > 0) {

                document.getElementById('favoritesHeader').style.display = 'block';

                favoriteChannels.forEach(channel => {

                    if (!document.getElementById(`fav-${channel.name}`)) {

                        favoriteContainer.appendChild(createChannelElement(channel, true));

                    }

                });

            } else {

                document.getElementById('favoritesHeader').style.display = 'none';

            }



            otherChannels.forEach(channel => allContainer.appendChild(createChannelElement(channel, false)));

        }



        function createChannelElement(channel, isFavorite) {

            const div = document.createElement('div');

            div.className = 'channel';

            div.id = isFavorite ? `fav-${channel.name}` : `chan-${channel.name}`;

            div.innerHTML = `

                <i class="fas fa-heart favorite-icon ${favorites.includes(channel.name) ? 'active' : ''}"  

                   onclick="toggleFavorite(event, '${channel.name}')"></i>  

                <a href="player-5.php?id=${channel.name}" target="_blank">  

                    <img src="${channel.logo}" alt="${channel.name}" width="150" height="150" class="rounded-lg mb-2">  

                </a>  

                <div class="text-center text-sm font-bold">${channel.name}</div>  

            `;

            return div;

        }



        function toggleDarkMode() {

            document.body.classList.toggle('dark-mode');

            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));

        }



        function loadDarkMode() {

            if (JSON.parse(localStorage.getItem('darkMode'))) {

                document.body.classList.add('dark-mode');

            }

        }



        document.addEventListener('DOMContentLoaded', () => {

            fetchChannels();

            loadDarkMode();

            document.getElementById('searchInput').addEventListener('input', function () {

                displayChannels(allChannels, this.value);

            });

        });

    </script>

</head>

<body>

    <header>

        <img class="logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSq9eDqCtfJOr7cD0Xte_tC2KRlbLZQS7dXZ6UhE-5UI171_frPjc3lC_A&s=10">

        <div class="search-container">

            <input id="searchInput" class="search-box" placeholder="Search channels...">

            <div class="toggle-label" onclick="toggleDarkMode()">

                <div class="toggle-ball"></div>

            </div>

        </div>

    </header>



    <div id="favoritesHeader" class="channel-grid" style="display:none;">Favorites</div>

    <div id="favoriteChannels" class="channel-grid"></div>

    <div class="channel-grid" id="allChannels"></div>

</body>

</html>
