window.onload = function(){
    generateAlbumDetail("../storage/thumbnail/default-thumbnail.png", "Hehe", "hhhh", 3001);
    generateSong('../storage/thumbnail/default-thumbnail.png', 'Song Title');
}

generateAlbumDetail = function(img_src, title, artist, total_duration){
    let content = document.getElementById("detail-album")
    let thumbnail = document.createElement('img')
    let main_info = document.createElement('div');
    let album_title = document.createElement('div');
    let album_artist = document.createElement('div');
    let duration = document.createElement('div');

    thumbnail.classList.add('thumbnail');
    main_info.classList.add('main-info');
    album_title.classList.add('album-title');
    album_artist.classList.add('album-artist');
    duration.classList.add('duration');

    let duration_str = "" + Math.floor(total_duration/3600) + " hours " + Math.floor(total_duration/60)%60 + " minutes " + total_duration%60 + " seconds";
    
    thumbnail.setAttribute('src', img_src);
    console.log(thumbnail.src);
    album_title.appendChild(document.createTextNode(title));
    album_artist.appendChild(document.createTextNode(artist));
    duration.appendChild(document.createTextNode(duration_str));
    main_info.appendChild(album_title);
    main_info.appendChild(album_artist);
    main_info.appendChild(duration);
    content.appendChild(thumbnail);
    content.appendChild(main_info);
}

generateSong = function(img_src, title){
    let contents = document.getElementsByClassName('contents')[0];
    let detail_song = document.createElement('div');
    let image_song = document.createElement('img');
    let title_song = document.createElement('div');

    detail_song.classList.add('detail-song');
    image_song.classList.add('song-image');
    title_song.classList.add('song-title');

    image_song.setAttribute('src', img_src);
    title_song.appendChild(document.createTextNode(title));
    detail_song.appendChild(image_song);
    detail_song.appendChild(title_song);
    contents.appendChild(detail_song);
}