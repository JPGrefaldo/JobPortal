export default {
    methods: {
        getColorByRole: function (role) {
            const colorDictionary = {
                Producer: [
                    'bg-blue',
                    'hover:bg-blue-dark',
                ],
                Crew: [
                    'bg-green',
                    'hover:bg-green-dark',
                ]
            }

            return colorDictionary[role]
        },
    }
}