# Hotel API Service

This repository contains a Laravel project for managing hotel data through a RESTful API. Follow the instructions below to set up and use the project.

## Setup Instructions

1. **Clone the Repository**: Clone the Laravel project repository from GitHub using the following command:

    ```
    git clone https://github.com/AmirAzmy/connetalentsTask.git
    ```

2. **Install Dependencies**: Navigate to the project directory and install the project dependencies using Composer:

    ```
    cd connetalentsTask
    composer install
    ```

3. **Run the Application**: Start the Laravel development server by running the following command:

    ```
    php artisan serve
    ```

    The application will be accessible at `http://localhost:8000` by default.

## API Usage

- **Endpoint**: Use the `/api/hotels` endpoint to retrieve hotel data.

- **Filters**:
  - You can filter hotels using the following parameters:
    - `name`: Filter hotels by name.
    - `price_from`: Filter hotels with prices greater than or equal to the specified value.
    - `price_to`: Filter hotels with prices less than or equal to the specified value.
    - `city`: Filter hotels by city.
    - `date_start`: Filter hotels available from the specified date.
    - `date_end`: Filter hotels available until the specified date.

  Example usage: `/api/hotels?name=Media%20One%20Hotel&price_from=80&price_to=120&city=Dubai&date_start=2023-10-10&date_end=2023-10-15`

- **Sorting**:
  - You can sort hotels using the following parameters:
    - `sort_by`: Sort hotels by price or name. (Accepts only "price" or "name")
    - `sort_type`: Specify the sorting order as "asc" (ascending) or "desc" (descending). (Accepts only "asc" or "desc")

  Example usage: `/api/hotels?sort_by=price&sort_type=asc`

**Note**: 
- Ensure that the Laravel development server is running (`php artisan serve`) before making API requests.
- Include the `Accept: application/json header` in your API requests to ensure JSON responses.
 


For further assistance or inquiries, please contact me at `eng.amirazmys@gmail.com`.

