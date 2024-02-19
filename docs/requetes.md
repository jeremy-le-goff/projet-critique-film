#### Récupérer tous les films.
```sql
SELECT * FROM movie
```
#### Récupérer les acteurs et leur(s) rôle(s) pour un film donné.
```sql
SELECT person.lastname,person.firstname, casting.role  
FROM person
INNER JOIN `casting` ON person.id = casting.person_id
WHERE casting.movie_id = 14;
```
#### Récupérer les genres associés à un film donné.
```sql
SELECT genre.name
FROM genre
JOIN movie_genre ON movie_genre.genre_id = genre.id
JOIN movie ON movie.id = movie_genre.movie_id
WHERE movie.id = 2;
-- OR
SELECT genre.name
FROM genre
JOIN movie_genre ON movie_genre.genre_id = genre.id
WHERE movie_genre.movie_id = 2;
```
#### Récupérer les saisons associées à un film/série donné.
```sql
SELECT *
FROM season
WHERE movie_id = 3;
```
#### Récupérer les critiques pour un film donné.
```sql
SELECT *
FROM review
WHERE movie_id = 3;
```
#### Récupérer les critiques pour un film donné, ainsi que le nom de l'utilisateur associé.
```sql
SELECT review.*, user.nickname 
FROM review
JOIN user ON review.user_id = user.id
WHERE review.movie_id = 3;
```
#### Calculer, pour chaque film, la moyenne des critiques par film (en une seule requête).
```sql
SELECT movie.title, AVG(review.rating)
FROM movie
JOIN review ON review.movie_id = movie.id
WHERE review.movie_id = 3;
```
#### Récupérer tous les films pour une année de sortie donnée.
```sql
SELECT *
FROM movie
WHERE YEAR(movie.release_date) = 2011;
```
#### Récupérer tous les films pour un tire donné (par ex. 'Epic Movie').
```sql
SELECT *
FROM movie
WHERE title = 'Epic Movie';
```
#### Récupérer tous les films dont le titre contient une chaîne donnée.
```sql
SELECT *
FROM movie
WHERE title LIKE '%epic%';
```
#### Récupérer la liste des films de la page 2 (grâce à LIMIT).
```sql
SELECT *
FROM movie
LIMIT 10;
```
#### Récupérer tous les films.
```sql
```
#### Récupérer tous les films.
```sql
```

