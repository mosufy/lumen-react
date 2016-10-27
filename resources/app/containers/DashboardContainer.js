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
import * as actionCreators from './../actions';
import {getTodos, addTodo, toggleTodo} from './../helpers/sdk';

class DashboardContainer extends React.Component {
  componentWillMount() {
    this.props.getTodos(this.props.auth.accessToken);
  }

  render() {
    var addTodo = this.props.addTodo.bind(this, this.props.auth.accessToken);
    var toggleCompleted = this.props.toggleCompleted.bind(this, this.props.auth.accessToken);

    return (
      <MyTodo items={this.props.todos}
              visibilityFilter={this.props.visibilityFilter}
              addTodo={addTodo}
              toggleCompleted={toggleCompleted}
              setVisibilityFilter={this.props.setVisibilityFilter}
              resetTodo={this.props.resetTodo}
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
        dispatch(actionCreators.getTodos(response));
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

      dispatch(actionCreators.updateLoader(0.5));

      addTodo(accessToken, todoName.val()).then(function (response) {
        dispatch(actionCreators.addTodo(response));
        dispatch(actionCreators.updateLoader(1));
      }).catch(function (error) {
        console.log('Failed to add ToDo');
        console.log(error);
      });

      todoName.val('');
    },
    toggleCompleted: (accessToken, e) => {
      var id = $(e.target).closest("input").attr('id');

      toggleTodo(accessToken, id).then(function (response) {
        dispatch(actionCreators.toggleCompleted(id, response));
      }).catch(function (error) {
        console.log('Failed to toggle ToDo');
        console.log(error);
      });

      dispatch(actionCreators.toggleCompleted(id));
    },
    setVisibilityFilter: (e) => {
      var filter = $(e.target).closest("button").attr('id');
      dispatch(actionCreators.setVisibilityFilter(filter));
    },
    resetTodo: () => {
      dispatch(actionCreators.resetTodo());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);