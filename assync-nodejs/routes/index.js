const express = require('express');
const { models } = require('../models');

const router = express.Router();

router.get('/test', async (req, res) => {
  try {
    const items = await models.product.findRandomPage();
    return res.json({
      items,
    });
  } catch (error) {
    return res.json({
      error: error.message,
    });
  }
});

module.exports = router;
