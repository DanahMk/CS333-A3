<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Nationalities</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
  >
</head>
<body>
  <main class="container">
    <h1>Statistics of Students Nationalities</h1>
    <table>
      <thead>
        <tr>
          <th><b>Year</b></th>
          <th><b>Semester</b></th>
          <th><b>The Programs</b></th>
          <th><b>Nationality</b></th>
          <th><b>Colleges</b></th>
          <th><b>Number of Students</b></th>
        </tr>
      </thead>

      <tbody>
        <script>
          async function getData() {
            const URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";
            try {
              const response = await fetch(URL);

              // Log the HTTP status and headers for debugging
              console.log(response.ok);
              console.log(response.status);
              console.log(response.statusText);
              console.log(response.headers);

              if (!response.ok) {
                throw new Error("Failed to fetch data: " + response.status);
              }

              const data = await response.json();

              if (data.results && Array.isArray(data.results)) {
                data.results.forEach(element => {
                  console.log(element); // Debugging

                  // Dynamically add rows to the table (optional enhancement)
                  const tableBody = document.querySelector("table tbody");
                  const row = document.createElement("tr");
                  row.innerHTML = `
                    <td>${element.year || "N/A"}</td>
                    <td>${element.semester || "N/A"}</td>
                    <td>${element.the_programs || "N/A"}</td>
                    <td>${element.nationality || "N/A"}</td>
                    <td>${element.colleges || "N/A"}</td>
                    <td>${element.number_of_students || "N/A"}</td>
                  `;
                  tableBody.appendChild(row);
                });
              } else {
                console.error("Invalid data structure");
              }
            } catch (error) {
              console.error("Error fetching data:", error);
            }
          }
          getData();
        </script>

        <?php 
        // Define the API URL
        $URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

        // Fetch data from the API
        $response = file_get_contents($URL);

        // Check if the response was successfully fetched
        if ($response === FALSE) {
            echo "<tr><td colspan='6'>Error: Unable to fetch data from the API.</td></tr>";
        } else {
            // Decode the JSON response
            $results = json_decode($response, true);
         // Check if data was successfully fetched and parsed
            if ($results && isset($results['results'])) {
                foreach ($results['results'] as $record) {
                    $year = $record['year'] ?? "N/A";
                    $semester = $record['semester'] ?? "N/A";
                    $program = $record['the_programs'] ?? "N/A";
                    $nationality = $record['nationality'] ?? "N/A";
                    $college = $record['colleges'] ?? "N/A";
                    $num_students = $record['number_of_students'] ?? "N/A";

                    echo "<tr>
                            <td>$year</td>
                            <td>$semester</td>
                            <td>$program</td>
                            <td>$nationality</td>
                            <td>$college</td>
                            <td>$num_students</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data available or failed to fetch data</td></tr>";
            }
        }
        ?>
      </tbody>
    </table>
  </main>
</body>
</html>
