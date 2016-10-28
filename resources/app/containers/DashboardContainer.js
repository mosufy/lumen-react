/**
 * DashboardContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodo from './../components/MyTodo';
import {connect} from 'react-redux';
import * as todoActions from './../actions/todoActions';
import * as authActions from './../actions/authActions';
import * as commonActions from './../actions/commonActions';
import {getTodos, addTodo, toggleTodo, deleteAllTodos} from './../helpers/sdk';

class DashboardContainer extends React.Component {
  componentWillMount() {
    this.props.getTodos(this.props.auth.accessToken);
  }

  render() {
    var addTodo = this.props.addTodo.bind(this, this.props.auth.accessToken);
    var toggleCompleted = this.props.toggleCompleted.bind(this, this.props.auth.accessToken);
    var resetTodo = this.props.resetTodo.bind(this, this.props.auth.accessToken);

    return (
      <MyTodo items={this.props.todos}
              visibilityFilter={this.props.visibilityFilter}
              addTodo={addTodo}
              toggleCompleted={toggleCompleted}
              setVisibilityFilter={this.props.setVisibilityFilter}
              resetTodo={resetTodo}
              loading={this.props.loading}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    todos: state.todos,
    visibilityFilter: state.visibilityFilter,
    auth: state.auth,
    loading: !state.loading.completed
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    getTodos: (accessToken) => {
      getTodos(accessToken).then(function (response) {
        dispatch(todoActions.getTodos(response));
      }).catch(function (error) {
        console.log('Failed fetching ToDos');
        console.log(error);
      });
    },
    addTodo: (accessToken, e) => {
      e.preventDefault();
      var todoName = $("#todo_name");

      if (todoName.val() == '') {
        return;
      }

      dispatch(commonActions.updateLoader(0.5));

      addTodo(accessToken, todoName.val()).then(function (response) {
        dispatch(todoActions.addTodo(response));
        dispatch(commonActions.updateLoader(1));
      }).catch(function (error) {
        console.log('Failed to add ToDo');
        console.log(error);
      });

      todoName.val('');
    },
    toggleCompleted: (accessToken, e) => {
      var id = $(e.target).closest("input").attr('id');

      toggleTodo(accessToken, id).then(function (response) {
        dispatch(todoActions.toggleCompleted(id, response));
      }).catch(function (error) {
        console.log('Failed to toggle ToDo');
        console.log(error);
      });

      dispatch(todoActions.toggleCompleted(id));
    },
    setVisibilityFilter: (e) => {
      var filter = $(e.target).closest("button").attr('id');
      dispatch(todoActions.setVisibilityFilter(filter));
    },
    resetTodo: (accessToken) => {
      deleteAllTodos(accessToken).then(function (response) {
        // do nothing
      }).catch(function (error) {
        console.log('Failed to reset ToDo');
        console.log(error);
      });

      dispatch(todoActions.resetTodo());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);