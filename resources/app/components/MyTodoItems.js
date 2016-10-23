/**
 * MyTodoItems
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';

export default class MyTodoItems extends React.Component {
  render() {
    return (
      <ul>
        {this.props.items.map(function (item) {
          return <li id={item.id} key={item.id}>{item.text}</li>;
        })}
      </ul>
    );
  }
}