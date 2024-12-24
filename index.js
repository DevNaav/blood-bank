const express =require('express');
const app = express();
const database = require("./config/database");
const userRoutes = require("./routes/User");



database.connect();
app.use(express.json());
app.use("/api/", userRoutes);
app.get('/',(req,res)=>{
  res.send("Sbh  bhdia hai");
})
app.listen(4141,()=>{
    console.log('Server Started');
});