/**
 * DashboardContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {createStore} from 'redux';
import TodoApp from './../reducers/index';
import MyTodo from './../components/MyTodo';

const store = createStore(TodoApp);

export default class DashboardContainer extends React.Component {
  constructor() {
    super();

    // bind functions to constructor
    this.addTodo = this.addTodo.bind(this);
    this.handleTodoNameChange = this.handleTodoNameChange.bind(this);

    // define states to be used
    this.state = {
      todoName: '',
    };
  }

  handleTodoNameChange(e) {
    this.setState({
      todoName: e.target.value
    });
  }

  addTodo(e) {
    e.preventDefault();
    store.dispatch({type: 'ADD_TODO', id: 1, text: this.state.todoName});
  }

  render() {
    return (
      <MyTodo items={store.getState().todos}
              handleTodoNameChange={this.handleTodoNameChange}
              addTodo={this.addTodo}/>
    );
  }
}