-- ** ЗАДАЧА 1 **

SELECT MAX(YEAR(NOW()) - YEAR(Student.birthday)) as max_year
FROM Student
JOIN Student_in_class sic ON Student.id = sic.student
JOIN Class ON sic.class = Class.id
WHERE Class.name LIKE '10%'

-- ** ЗАДАЧА 2 без JOIN**

DELETE FROM Company
WHERE id IN (
    SELECT company
    FROM Trip
    GROUP BY company
    HAVING COUNT(id) = (
        SELECT COUNT(id)
        FROM Trip
        GROUP BY company
        ORDER BY COUNT(id)
        LIMIT 1
    )
);

-- ** ЗАДАЧА 2 с JOIN**
DELETE FROM Company
WHERE id IN (
    SELECT company
    FROM (
        SELECT company, COUNT(id) as count_id
        FROM Trip
        GROUP BY company
    ) AS TripCount
    JOIN (
        SELECT COUNT(id) as min_count
        FROM Trip
        GROUP BY company
        ORDER BY COUNT(id)
        LIMIT 1
    ) AS MinCount
    ON TripCount.count_id = MinCount.min_count
);


-- ** ЗАДАЧА 3 ** 

SELECT ROUND((SELECT COUNT(*) FROM 
    (SELECT DISTINCT owner_id FROM Rooms 
    JOIN Reservations ON Rooms.id = Reservations.room_id 
    UNION
    SELECT DISTINCT user_id FROM Reservations) AS users)*100/(SELECT COUNT(id) FROM Users), 2) AS percent
