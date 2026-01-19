# Void Music

Void Music is a PHP-based music streaming web application created as an academic project during the fourth semester of engineering. It allows users to register, browse songs, create playlists, like music, upload songs, and manage their profiles. The project uses a combination of frontend and backend technologies to deliver a complete music portal experience with user authentication and dynamic content.

---

## Features

- User registration and login  
- Browse all available songs  
- Like and favorite songs  
- Create and manage personal playlists  
- Upload new songs  
- Dynamic user profile pages  
- Music search functionality  
- Admin interface for song approval and message handling  

---

## Technology Stack

This project uses the following technologies:

- PHP for server-side logic  
- MySQL for database storage  
- HTML and CSS for structure and styling  
- Bootstrap for responsive layout  
- JavaScript and jQuery for frontend interactivity  
- AJAX for real-time updates without page reloads  

---

## Folder Structure

```
/
├── includes/                  # PHP include files and helpers
├── jquery/                   # jQuery library files
├── palette/                  # Custom palettes or assets
├── admin.php                 # Admin dashboard
├── index.php                 # Homepage
├── login.php                 # User login page
├── register.php              # User signup page
├── music.php                 # Music display and streaming
├── playlist.php              # Playlist view
├── profile.php               # User profile
├── upload_song.php           # Upload form and logic
├── contact.php               # Contact form page
├── settings.php              # User settings page
└── other utility scripts     # Including AJAX handlers and form processors
```

---

## Setup Instructions

1. Clone the repository:
```bash
git clone https://github.com/SOHAM-THUMMAR/Void-Music.git
cd Void-Music
```

2. Configure a local web server (XAMPP, WAMP, or similar) with PHP and MySQL.

3. Create a database in MySQL and import the provided SQL schema (if available).

4. Update database credentials in the PHP config file.

5. Start your web server and navigate to localhost in your browser.

6. Register a new account or use existing credentials to log in.

---

## How It Works

- Users register and log in through secure forms.  
- Once logged in, they can browse through available music.  
- Songs can be liked or added to user playlists.  
- Users can upload their own music files.  
- Admin panel handles pending song approvals and user messages.

---

## Future Improvements

- Add real audio streaming (with caching)  
- Implement user roles with better permissions  
- Add social sharing  
- Improve UI responsiveness  
- Add AJAX-powered infinite scroll for music lists  
- Integrate search filters by genre and artist  

---

## Contributing

To contribute:

1. Fork the repository  
2. Create a feature branch:
```bash
git checkout -b feature-name
```
3. Commit your changes:
```bash
git commit -m "Add some feature"
```
4. Push the branch and open a pull request.
