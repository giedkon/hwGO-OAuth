export class errorHandler {
    static alertError(error) {
        let errorOutput = ""
        if(error.response.data.message) {
            Object.keys(error.response.data.errors).forEach((value, key, arr) => {
                errorOutput += error.response.data.errors[value][0];
                if (!Object.is(arr.length - 1, key)) {
                    errorOutput += "\n";
                }
            });
        } else {
            errorOutput = error.response.data;
        }
        return errorOutput;
    }
}
