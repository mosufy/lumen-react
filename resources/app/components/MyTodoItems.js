/**
 * MyTodoItems
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';

const MyTodoItems = (props) => {
  if (props.items.length == 0) {
    return (
      <div>
        No items in your ToDo.<br/>
        Start by creating a new ToDo.
      </div>
    );
  }

  return (
    <ul>
      {props.items.map(item => {
        if (props.visibilityFilter == 'SHOW_ACTIVE' && item.completed) {
          return;
        }

        if (props.visibilityFilter == 'SHOW_COMPLETED' && !item.completed) {
          return;
        }

        let itemText = item.text;
        let defaultChecked;

        if (item.completed) {
          itemText = (
            <del>{item.text}</del>
          );
          defaultChecked = 'defaultChecked';
        }

        return (
          <div className="checkbox" key={item.id}>
            <label>
              <input id={item.id} type="checkbox" value={item.id} onClick={props.toggleCompleted}
                     defaultChecked={defaultChecked}/>{itemText}
            </label>
          </div>
        );
      })}
    </ul>
  );
};

export default MyTodoItems;