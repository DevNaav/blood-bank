const mongoose = require("mongoose");
require("dotenv").config();

exports.connect =async () => {
    try {
        await mongoose.connect("mongodb+srv://abhigoyals101:5xTwRgn9fDQtz7Ub@bloodbank.6wmyg.mongodb.net/?retryWrites=true&w=majority&appName=BloodBank",{
            dbName:"bloodBank"
        });
        console.log("Connected to database");
    } catch (error) {
        console.error("Error connecting to database",error);
    }
};