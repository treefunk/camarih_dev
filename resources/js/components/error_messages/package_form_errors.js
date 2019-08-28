export default {
    name: {
        required: "Name is required."
    },
    minimum_count: {
        required: "You did not specify the minimum count.",
        non_numeric: "Minimum count must be a number."
    },
    location_name: {
        required: "Location is required."
    },
    package_category: {
        required: "Tour Package is required."
    },
    rate: {
        required: "Rate is required.",
        non_numeric: "Rate must be a number."
    },
    package_locations: {
        required: "Destination is required."
    }
}
