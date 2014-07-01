<?php
// add_item_types_to_DB();
  $char_info = $grizismudb->query("Select cLevel,Resets,Money,Class,QuestNumber,QuestMonsters,QuestInCurse From Character Where AccountId='Admin' AND Name='Admin'")->fetchAll();
  get_quest_item($char_info[0]);