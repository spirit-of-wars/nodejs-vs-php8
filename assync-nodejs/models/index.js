const { Sequelize } = require('sequelize');
const { connectionString, sequelizeLogging } = require('../config/config');

// connect to DB
const sequelize = new Sequelize(connectionString, {
  logging: sequelizeLogging && ((...msg) => console.log(msg)),
  schema: 'common',
});

// test connection
const checkConnection = async function () {
  try {
    await sequelize.authenticate();
    console.log('Connection has been established successfully.');
  } catch (error) {
    console.error('Unable to connect to the database');
    console.error(error.message);
    process.exit(1);
  }
}

// define models
require('./product.model')(sequelize);

module.exports = sequelize;
module.exports.checkConnection = checkConnection;
