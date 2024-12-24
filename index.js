const express =require('express');
const app = express();
const database = require("./config/database");
const userRoutes = require("./routes/User");
const cors=require("cors");


database.connect();
app.use(express.json());
app.use(cors("*"));
app.use("/api/", userRoutes);
app.get('/',(req,res)=>{
  res.send("Sbh  bhdia hai");
})
app.listen(4141,()=>{
    console.log('Server Started');
});